<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Shop data from middleware
        $shop = $request->shop;

        // Fetch data specific to the shop
        $barang = Barang::where('shop_id', $shop->id)->count();

        return view('dashboard.dashboard', [
            'barang' => $barang,
            'shop' => $shop, // Pass shop data to the view
        ]);
    }
}

