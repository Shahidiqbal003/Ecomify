<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Collection;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Shop-specific products
        $shop = $request->shop;
        $products = Product::where('shop_id', $shop->id)->orderBy('id', 'asc')->get();

        // Map over products to decode JSON fields and fetch category relations
        $products = $products->map(function ($product) {
            $product->product_images_data = json_decode($product->product_images_data);
            $product->sizes = json_decode($product->sizes);
            $product->colors = json_decode($product->colors);
            $product->color_images = json_decode($product->color_images);
            $product->categories = Collection::whereIn('id', json_decode($product->category_ids))->get();

            return $product;
        });

        return view('product.index', [
            'products' => $products,
            'shop' => $shop,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $shop = $request->shop;
        $categories = Collection::where('shop_id', $shop->id)->get(); // Shop-specific categories
        return view('product.add', compact('categories', 'shop'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $shop = $request->shop;

        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'slug' => 'required|string|max:255',
            'compare_at_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'variations' => 'nullable|string',
            'productDiscription' => 'nullable',
            'sizes' => 'nullable|array',
            'sizes.*' => 'nullable|string|max:50',
            'colors' => 'nullable|array',
            'colors.*' => 'nullable|string|max:50',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'nullable|integer|exists:collections,id',
            'cover_image' => 'nullable|file|mimes:jpg,jpeg,png,webp',
            'product_images' => 'nullable|array',
            'product_images.*' => 'nullable|file|mimes:jpg,jpeg,png,webp',
            'color_images' => 'nullable|array',
            'color_images.*' => 'nullable|file|mimes:jpg,jpeg,png,webp',
        ]);

        // Prepare data
        $data = $request->except(['color_images', 'product_images', 'cover_image']);
        $data['shop_id'] = $shop->id;

        // Handle JSON fields
        $data['category_ids'] = $request->has('category_ids') ? json_encode($request->category_ids) : null;
        $data['sizes'] = $request->has('sizes') ? json_encode($request->sizes) : null;
        $data['colors'] = $request->has('colors') ? json_encode($request->colors) : null;

        // File uploads
        $data['color_images'] = $request->hasFile('color_images') ? json_encode($this->uploadImages($request->file('color_images'), $shop->id)) : null;
        $data['product_images_data'] = $request->hasFile('product_images') ? json_encode($this->uploadImages($request->file('product_images'), $shop->id)) : null;
        $data['cover_image_data'] = $request->hasFile('cover_image') ? $this->uploadImage($request->file('cover_image'), $shop->id) : null;

        // Create the product
        Product::create($data);

        session()->flash('success', 'Product successfully saved!');
        return redirect()->route('product.index', ['shop' => $shop->name]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $shopname, $id)
    {
        $shop = $request->shop;
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);
        $categories = Collection::where('shop_id', $shop->id)->get();

        return view('product.edit', compact('product', 'categories', 'shop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $shopname, $id)
    {
        $shop = $request->shop;

        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'slug' => 'required|string|max:255',
            'compare_at_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'variations' => 'nullable|string',
            'productDiscription' => 'nullable',
            'sizes' => 'nullable|array',
            'sizes.*' => 'nullable|string|max:50',
            'colors' => 'nullable|array',
            'colors.*' => 'nullable|string|max:50',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'nullable|integer|exists:collections,id',
            'cover_image' => 'nullable|file|mimes:jpg,jpeg,png,webp',
            'product_images' => 'nullable|array',
            'product_images.*' => 'nullable|file|mimes:jpg,jpeg,png,webp',
            'color_images' => 'nullable|array',
            'color_images.*' => 'nullable|file|mimes:jpg,jpeg,png,webp',
        ]);

        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        // Update data
        $data = $request->except(['color_images', 'product_images', 'cover_image']);
        $data['category_ids'] = $request->has('category_ids') ? json_encode($request->category_ids) : null;
        $data['sizes'] = $request->has('sizes') ? json_encode($request->sizes) : null;
        $data['colors'] = $request->has('colors') ? json_encode($request->colors) : null;

        // File uploads
        if ($request->hasFile('color_images')) {
            $data['color_images'] = json_encode($this->uploadImages($request->file('color_images'), $shop->id));
        }
        if ($request->hasFile('product_images')) {
            $data['product_images_data'] = json_encode($this->uploadImages($request->file('product_images'), $shop->id));
        }
        if ($request->hasFile('cover_image')) {
            $data['cover_image_data'] = $this->uploadImage($request->file('cover_image'), $shop->id);
        }

        $product->update($data);

        session()->flash('success', 'Product successfully updated!');
        return redirect()->route('product.index', ['shop' => $shop->name]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $shopname, $id)
    {
        $shop = $request->shop;

        try {
            $product = Product::where('shop_id', $shop->id)->findOrFail($id);
            $product->delete();

            session()->flash('success', 'Product successfully deleted!');
            return redirect(route('product.index', ['shop' => $shop->name]));
        } catch (Exception $ex) {
            session()->flash('error', 'Cannot delete, Product already used!');
            return redirect(route('product.index', ['shop' => $shop->name]));
        }
    }

    /**
     * Helper function to upload multiple images and return their names.
     */
    private function uploadImages($images, $shopId)
    {
        $uploadedImages = [];
        foreach ($images as $image) {
            $uploadedImages[] = $this->uploadImage($image, $shopId);
        }
        return $uploadedImages;
    }

    /**
     * Helper function to upload a single image and return its name.
     */
    private function uploadImage($image, $shopId)
    {
        $folderPath = public_path('assets/uploads/product/' . $shopId);

        // Ensure the folder exists
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $imageName = time() . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
        $image->move($folderPath, $imageName);
        return $shopId . '/' . $imageName;
    }

    public function updateStatus(Request $request, $shop)
    {
        $shop = $request->shop;

        $product = Product::where('id', $request->product_id)
                        ->where('shop_id', $shop->id)
                        ->firstOrFail();

        // Toggle the status
        $product->status = !$product->status;
        $product->save();

        return redirect()->route('product.index', ['shop' => $shop->name])->with('success', 'Product Status updated successfully.');
    }
}
