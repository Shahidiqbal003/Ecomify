<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Shop;

class CouponController extends Controller
{
    public function index($shop)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();
        $coupons = Coupon::where('shop_id', $shop->id)->get();

        return view('coupons.index', compact('coupons', 'shop'));
    }

    public function create($shop)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();
        $products = Product::where('shop_id', $shop->id)->get();

        return view('coupons.add', compact('shop', 'products'));
    }

    public function store(Request $request, $shop)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();

        $data = $request->validate([
            'code' => 'required|max:100|unique:coupons,code,NULL,id,shop_id,' . $shop->id,
            'discount_type' => 'nullable',
            'discount_value' => 'nullable',
            'free_shipping' => 'nullable',
            'expiry_date' => 'nullable',
            'status' => 'nullable',
            'qty' => 'nullable',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $data['shop_id'] = $shop->id;
        $data['product_ids'] = json_encode($request->product_ids);

        Coupon::create($data);

        return redirect()->route('coupon.index', $shop->name)->with('success', 'Coupon created successfully.');
    }

    public function edit($shop, $id)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();
        $coupon = Coupon::where('shop_id', $shop->id)->findOrFail($id);
        $products = Product::where('shop_id', $shop->id)->get();

        return view('coupons.edit', compact('shop', 'coupon', 'products'));
    }

    public function update(Request $request, $shop, $id)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();
        $coupon = Coupon::where('shop_id', $shop->id)->findOrFail($id);

        $data = $request->validate([
            'code' => 'required|max:100|unique:coupons,code,' . $id . ',id,shop_id,' . $shop->id,
            'discount_type' => 'nullable',
            'discount_value' => 'nullable',
            'free_shipping' => 'nullable',
            'expiry_date' => 'nullable',
            'status' => 'nullable',
            'qty' => 'nullable',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $data['product_ids'] = json_encode($request->product_ids);

        $coupon->update($data);

        return redirect()->route('coupon.index', $shop->name)->with('success', 'Coupon updated successfully.');
    }


    public function destroy($shop, $id)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();
        $coupon = Coupon::where('shop_id', $shop->id)->findOrFail($id);
        $coupon->delete();

        return redirect()->route('coupons.index', $shop->name)->with('success', 'Coupon deleted successfully.');
    }

    public function validateCouponCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'shop_id' => 'required|exists:shops,id',
        ]);

        $exists = Coupon::where('shop_id', $request->shop_id)
            ->where('code', $request->code)
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    public function updateStatus(Request $request, $shop)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();

        $coupon = Coupon::where('id', $request->coupon_id)
                        ->where('shop_id', $shop->id)
                        ->firstOrFail();

        // Toggle the status
        $coupon->status = !$coupon->status;
        $coupon->save();

        return redirect()->route('coupon.index', ['shop' => $shop->name])->with('success', 'Coupon status updated successfully.');
    }

}
