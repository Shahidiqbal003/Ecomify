<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Shop;

class IdentifyShop
{
    public function handle($request, Closure $next)
    {
        // Shop ka naam route se lein
        $shopName = $request->route('shop');

        // Database mein shop ko dhoondhein
        $shop = Shop::where('name', $shopName)->first();

        if (!$shop) {
            abort(404, 'Shop not found'); // Agar shop na mile to 404 error
        }

        // Check if the request is for frontend
        if ($request->is('*/store*')) {
            // Agar shop ka status = 0 hai, to custom "Store Not Found" page dikhayein
            if ($shop->status === 0) {
                return response()->view('ui.storelocked', ['shopName' => $shopName], 403);
            }
        }

        // Request mein shop ka data add karein
        $request->merge(['shop' => $shop]);

        return $next($request);
    }
}
