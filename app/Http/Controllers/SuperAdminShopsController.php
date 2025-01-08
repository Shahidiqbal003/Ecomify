<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class SuperAdminShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shops = Shop::all();
        return view('super_admin.shops.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.barang-add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:barangs',
            'category' => 'required',
            'supplier' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'note' => 'max:1000',
        ]);

        $barang = Barang::create($request->all());

        session()->flash('success', 'Data successfully saved!');
        return redirect(route('barang.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_barang)
    {
        $barang = barang::findOrFail($id_barang);

        return view('barang.barang-edit', [
            'barang' => $barang,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_barang)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:barangs,name,' . $id_barang . ',id_barang',
            'category' => 'required',
            'supplier' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'note' => 'max:1000',
        ]);

        $barang = Barang::findOrFail($id_barang);
        $barang->update($validated);

        session()->flash('success', 'Data successfully Updated!');
        return redirect(route('barang.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_barang)
    {
        try {
            $deletedbarang = Barang::findOrFail($id_barang);

            $deletedbarang->delete();

            session()->flash('success', 'Data successfully Deleted!');
            return redirect(route('barang.index'));
        } catch (Exception $ex) {

            session()->flash('error', 'Cant deleted, Barang already used !');
            return redirect(route('barang.index'));
        }
    }

    public function toggleStatus($id, Request $request)
    {
        $shop = Shop::findOrFail($id);

        // Toggle the status based on the checkbox value
        $shop->status = $request->has('status') ? 1 : 0;
        $shop->save();

        return back()->with('success', 'Shop status updated successfully.');
    }
}
