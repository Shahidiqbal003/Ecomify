<?php

namespace App\Http\Controllers;

use App\Models\StoreSetting;
use App\Models\Shop;
use Illuminate\Http\Request;

class StoreSettingController extends Controller
{
    public function index($shopName)
    {
        $shop = Shop::where('name', $shopName)->firstOrFail();
        $settings = StoreSetting::where('shop_id', $shop->id)->first();

        return view('settings.index', compact('shop', 'settings'));
    }

    public function store(Request $request, $shopName)
    {
        // dd($request->all());
        $shop = Shop::where('name', $shopName)->firstOrFail();

        // Extract last segment of previous URL
        $previousUrl = url()->previous();
        $previousPage = basename(parse_url($previousUrl, PHP_URL_PATH)); // Extract last part of URL

        \Log::info("Previous URL: " . $previousUrl);
        \Log::info("Extracted Page Name: " . $previousPage);

        // Validate incoming request
        $data = $request->validate([
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:1024',
            'shop_name' => 'nullable',
            'description' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'whatsapp_number' => 'nullable',
            'is_whatsapp' => 'nullable',
            'fe_banner' => 'nullable',
            'topbar_text' => 'nullable',
            'is_topbar' => 'nullable',
            'is_navbar' => 'nullable',
            'customer_reviews' => 'nullable|array',
            'customer_reviews.*.name' => 'required|string|max:255',
            'customer_reviews.*.stars' => 'required|integer|min:1|max:5',
            'customer_reviews.*.review' => 'required|string',
            'email_show' => 'nullable',
            'email_required' => 'nullable',
            'country_show' => 'nullable',
            'country_required' => 'nullable',
            'first_name_show' => 'nullable',
            'first_name_required' => 'nullable',
            'last_name_show' => 'nullable',
            'last_name_required' => 'nullable',
            'company_show' => 'nullable',
            'company_required' => 'nullable',
            'address_show' => 'nullable',
            'address_required' => 'nullable',
            'apartment_show' => 'nullable',
            'apartment_required' => 'nullable',
            'city_show' => 'nullable',
            'city_required' => 'nullable',
            'postal_code_show' => 'nullable',
            'postal_code_required' => 'nullable',
            'phone_show' => 'nullable',
            'phone_required' => 'nullable',
            'note_show' => 'nullable',
            'note_required' => 'nullable',
            'email_quick_buy' => 'nullable',
            'country_quick_buy' => 'nullable',
            'first_name_quick_buy' => 'nullable',
            'last_name_quick_buy' => 'nullable',
            'company_quick_buy' => 'nullable',
            'address_quick_buy' => 'nullable',
            'apartment_quick_buy' => 'nullable',
            'city_quick_buy' => 'nullable',
            'postal_code_quick_buy' => 'nullable',
            'phone_quick_buy' => 'nullable',
            'note_quick_buy' => 'nullable',
        ]);

        // Directory for store-specific uploads
        $storeDirectory = 'assets/uploads/product/' . $shop->id;

        // Ensure directory exists
        if (!file_exists(public_path($storeDirectory))) {
            mkdir(public_path($storeDirectory), 0777, true);
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $storeDirectory . '/logo_' . time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move(public_path($storeDirectory), $logoPath);
            $data['logo'] = $logoPath;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $faviconPath = $storeDirectory . '/favicon_' . time() . '.' . $request->file('favicon')->getClientOriginalExtension();
            $request->file('favicon')->move(public_path($storeDirectory), $faviconPath);
            $data['favicon'] = $faviconPath;
        }

        // Handle fe_banner upload
        if ($request->hasFile('fe_banner')) {
            $feBannerPath = $storeDirectory . '/fe_banner_' . time() . '.' . $request->file('fe_banner')->getClientOriginalExtension();
            $request->file('fe_banner')->move(public_path($storeDirectory), $feBannerPath);
            $data['fe_banner'] = $feBannerPath;
        }

        // Add shop_id to data
        $data['shop_id'] = $shop->id;
        $data['customer_review_detail'] = json_encode($request->customer_reviews);
        // Create or update settings
        StoreSetting::updateOrCreate(['shop_id' => $shop->id], $data);

        // **Redirect based on previous page name**
        if ($previousPage === 'homePage') {
            return redirect()->route('settings.homePage', ['shop' => $shop->name])->with('success', 'Settings updated successfully.');
        }elseif($previousPage === 'checkout_form'){
            return redirect()->route('settings.checkout_form', ['shop' => $shop->name])->with('success', 'Settings updated successfully.');
        }else{
            return redirect()->route('settings.index', ['shop' => $shop->name])->with('success', 'Settings updated successfully.');
        }

    }

    public function homePage($shop)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();
        $settings = StoreSetting::where('shop_id', $shop->id)->first();

        return view('settings.home_page', compact('shop', 'settings'));
    }

    public function checkout_form($shop)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();
        $settings = StoreSetting::where('shop_id', $shop->id)->first();

        return view('settings.checkout_form', compact('shop', 'settings'));
    }

}
