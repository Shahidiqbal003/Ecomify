<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Shop;
use App\Models\StoreSetting;
use App\Models\Collection;
use App\Models\StorePage;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share the shop settings and collections with all views
        View::composer('*', function ($view) {
            $shopName = request()->route('shop'); // Get current shop name from route
            $storeSettings = null;
            $collections = []; // Initialize collections as empty
            $pages = [];
            if ($shopName) {
                $shop = Shop::where('name', $shopName)->first();
                if ($shop) {
                    // Fetch store settings based on shop_id
                    $storeSettings = StoreSetting::where('shop_id', $shop->id)->first();

                    // Fetch collections based on shop_id
                    $collections = Collection::where('shop_id', $shop->id)->where('status','1')->get();
                    $pages = StorePage::where('shop_id', $shop->id)->first();
                }
            }

            // Pass store settings and collections to all views
            $view->with('storeSettings', $storeSettings ?: [])
                 ->with('collections', $collections ?: [])
                 ->with('pages', $pages ?: []);
        });
    }
}

