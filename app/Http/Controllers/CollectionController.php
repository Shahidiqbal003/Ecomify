<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Shop-specific collections
        $shop = $request->shop;
        $collection = Collection::where('shop_id', $shop->id)->orderBy('name', 'asc')->get();

        return view('collection.index', [
            'collection' => $collection,
            'shop' => $shop,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $shop = $request->shop;

        return view('collection.add', [
            'shop' => $shop,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $shop = $request->shop;

        $validated = $request->validate([
            'name' => 'required|max:100|unique:collections,name,NULL,id,shop_id,' . $shop->id,
            'note' => 'max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure image is valid
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/uploads'), $imageName);
        }

        Collection::create([
            'name' => $validated['name'],
            'note' => $validated['note'] ?? null,
            'image' => isset($imageName) ? $imageName : null,
            'shop_id' => $shop->id, // Link to shop
        ]);

        session()->flash('success', 'Data successfully saved!');
        return redirect(route('collection.index', ['shop' => $shop->name]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $shopname, $id)
    {
        $shop = $request->shop;
        $collection = Collection::where('shop_id', $shop->id)->findOrFail($id);

        return view('collection.edit', [
            'collection' => $collection,
            'shop' => $shop,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $shopname, $id)
    {
        $shop = $request->shop;

        $validated = $request->validate([
            'name' => 'required|max:100|unique:collections,name,' . $id . ',id,shop_id,' . $shop->id,
            'note' => 'max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure image is valid if provided
        ]);

        $collection = Collection::where('shop_id', $shop->id)->findOrFail($id);

        if ($request->hasFile('image')) {
            if ($collection->image && file_exists(public_path('assets/uploads/' . $collection->image))) {
                unlink(public_path('assets/uploads/' . $collection->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/uploads'), $imageName);

            $validated['image'] = $imageName;
        }

        $validated['shop_id'] = $shop->id;

        $collection->update($validated);

        session()->flash('success', 'Data successfully updated!');
        return redirect(route('collection.index', ['shop' => $shop->name]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $shopname, $id)
    {
        $shop = $request->shop;

        try {
            $collection = Collection::where('shop_id', $shop->id)->findOrFail($id);

            if ($collection->image && file_exists(public_path('assets/uploads/' . $collection->image))) {
                unlink(public_path('assets/uploads/' . $collection->image));
            }

            $collection->delete();

            session()->flash('success', 'Data successfully deleted!');
            return redirect(route('collection.index', ['shop' => $shop->name]));
        } catch (Exception $ex) {
            session()->flash('error', 'Cannot delete, collection already used!');
            return redirect(route('collection.index', ['shop' => $shop->name]));
        }
    }

    public function updateStatus(Request $request, $shop)
    {
        $shop = $request->shop;

        $collection = Collection::where('id', $request->collection_id)
                        ->where('shop_id', $shop->id)
                        ->firstOrFail();

        // Toggle the status
        $collection->status = !$collection->status;
        $collection->save();

        return redirect()->route('collection.index', ['shop' => $shop->name])->with('success', 'Collection Status updated successfully.');
    }
}
