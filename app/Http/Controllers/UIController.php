<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Collection;
use App\Models\Contact;
use App\Models\Shop;
use App\Models\StorePage;
use Illuminate\Http\Request;

class UIController extends Controller
{
    public function index(Request $request)
    {
        // Get shop data from middleware
        $shop = $request->shop;

        // Fetch 8 latest products related to the shop, ordered by ID descending
        $products = Product::where('shop_id', $shop->id)
            ->where('status', 1)
            ->orderBy('id', 'desc') // Descending order
            ->take(8) // Fetch only 8 products
            ->get();

        // Decode JSON and fetch category data for all products
        $products->transform(function ($product) {
            $product->product_images_data = json_decode($product->product_images_data, true);
            $product->cover_first_image = $product->product_images_data[0] ?? null;
            $product->sizes = json_decode($product->sizes, true);
            $product->colors = json_decode($product->colors, true);
            $product->color_images = json_decode($product->color_images, true);

            if (!empty($product->category_ids)) {
                $categoryIds = json_decode($product->category_ids, true);
                $product->categories = Collection::whereIn('id', $categoryIds)->get();
            } else {
                $product->categories = collect();
            }

            return $product;
        });

        // Fetch single product with ID 5
        $single_product = Product::where('shop_id', $shop->id)
            ->where('id', 5)
            ->first();

        // Decode JSON for the single product if it exists
        if ($single_product) {
            $single_product->product_images_data = json_decode($single_product->product_images_data, true);
            $single_product->sizes = json_decode($single_product->sizes, true);
            $single_product->colors = json_decode($single_product->colors, true);
            $single_product->color_images = json_decode($single_product->color_images, true);

            if (!empty($single_product->category_ids)) {
                $categoryIds = json_decode($single_product->category_ids, true);
                $single_product->categories = Collection::whereIn('id', $categoryIds)->get();
            } else {
                $single_product->categories = collect();
            }

            $single_product->shipping = number_format(300, 2);
        }

        // Return view with optimized data
        return view('ui.index', [
            'products' => $products,
            'product' => $single_product,
            'shop' => $shop, // Pass shop data to the view
        ]);
    }


    public function about(Request $request)
    {
        $shop = $request->shop; // Shop from middleware
        return view('ui.about', [
            'title' => 'About Us',
            'content' => 'Learn more about our company and mission.',
            'shop' => $shop,
        ]);
    }

    public function contact(Request $request)
    {
        $shop = $request->shop; // Shop from middleware
        return view('ui.contact', [
            'title' => 'Contact',
            'content' => 'Feel free to contact us.',
            'shop' => $shop,
        ]);
    }

    public function storeContact(Request $request)
    {
        $shop = $request->shop;
        $validated = $request->validate([
            'name'    => 'required',
            'email'   => 'required',
            'phone'   => 'required',
            'comment' => 'nullable',
        ]);

        $validated['shop_id'] = $shop->id;
        Contact::create($validated);

        return back()->with('success', 'Your message has been submitted successfully.');
    }

    public function shop(Request $request)
    {
        $shop = $request->shop;

        $products = Product::where('shop_id', $shop->id)->where('status', 1)->orderBy('id', 'asc')->get();

        $products = $products->map(function ($product) {
            $product->product_images_data = json_decode($product->product_images_data);
            $product->cover_first_image = isset($product->product_images_data[0]) ? $product->product_images_data[0] : null;
            $product->sizes = json_decode($product->sizes);
            $product->colors = json_decode($product->colors);
            $product->color_images = json_decode($product->color_images);
            $product->categories = Collection::whereIn('id', json_decode($product->category_ids))->get();

            return $product;
        });

        return view('ui.shop', [
            'products' => $products,
            'shop' => $shop,
        ]);
    }

    public function products(Request $request, $shopname, $slug)
    {
        $shop = $request->shop;

        $product = Product::where('shop_id', $shop->id)->where('slug', $slug)->firstOrFail();
        $product->product_images_data = json_decode($product->product_images_data);
        $product->sizes = json_decode($product->sizes);
        $product->colors = json_decode($product->colors);
        $product->color_images = json_decode($product->color_images);
        $product->categories = Collection::whereIn('id', json_decode($product->category_ids))->get();
        $product->shipping = number_format('300', 2);

        return view('ui.products', [
            'product' => $product,
            'shop' => $shop,
        ]);
    }

    public function showCollection($shop, $collectionName)
    {
        $formattedName = str_replace('-', ' ', strtolower($collectionName));

        $shop = Shop::where('name', $shop)->firstOrFail();

        $collection = Collection::where('shop_id', $shop->id)
                                ->where('name', $formattedName)
                                ->firstOrFail();

        $products = Product::whereJsonContains('category_ids', (string) $collection->id)
                           ->where('shop_id', $shop->id)
                           ->get();

        return view('ui.collection', compact('collection', 'products'));
    }

    public function showPage($shopName, $page)
    {
        $shop = Shop::where('name', $shopName)->firstOrFail();
        $storePage = StorePage::where('shop_id', $shop->id)->first();
        return view('ui.page', compact('shop', 'page', 'storePage'));
    }


}
