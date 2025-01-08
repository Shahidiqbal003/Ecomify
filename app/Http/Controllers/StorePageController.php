<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StorePage;
use App\Models\Shop;

class StorePageController extends Controller
{
    public function index($shopName)
    {
        $shop = Shop::where('name', $shopName)->firstOrFail();
        $pages = StorePage::where('shop_id', $shop->id)->first();

        return view('pages.index', compact('shop', 'pages'));
    }

    public function edit($shopName, $page)
    {
        $shop = Shop::where('name', $shopName)->firstOrFail();
        $pages = StorePage::firstOrCreate(
            ['shop_id' => $shop->id],
            [
                'about' => '',
                'contact' => '',
                'faq' => '',
                'how_to_order' => '',
                'shipping_details' => '',
                'payment_details' => '',
                'privacy_policy' => '',
                'return_refund' => '',
                'terms_of_service' => '',
            ]
        );

        return view('pages.edit', compact('shop', 'pages', 'page'));
    }

    public function update(Request $request, $shopName, $page)
    {
        $shop = Shop::where('name', $shopName)->firstOrFail();
        $validPages = ['about', 'contact', 'faq', 'how_to_order', 'shipping_details', 'payment_details', 'privacy_policy', 'return_refund', 'terms_of_service'];

        if (!in_array($page, $validPages)) {
            return redirect()->route('pages.index', ['shop' => $shop->name])
                ->with('error', 'Invalid page.');
        }

        $data = $request->validate([
            $page => 'nullable|string',
        ]);

        StorePage::updateOrCreate(
            ['shop_id' => $shop->id],
            [$page => $data[$page]]
        );

        return redirect()->route('pages.index', ['shop' => $shop->name])
            ->with('success', ucfirst(str_replace('_', ' ', $page)) . ' updated successfully.');
    }
}
