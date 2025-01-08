<?php

use App\Http\Controllers\SuperFrontendController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SuperAdminShopsController;

use App\Http\Controllers\UIController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\StoreSettingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StorePageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Supper Frontend Routes
Route::get('/', [SuperFrontendController::class, 'index'])->name('super.frontend');

// Supper Admin Panel Routes for Multi-User Shops
Route::prefix('admin')->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('super_admin.login')->middleware('guest');
    Route::post('/', [AuthController::class, 'authenticate']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('super_admin.logout')->middleware('auth');
    Route::get('/register', [AuthController::class, 'register'])->name('super_admin.register');
    Route::post('/register', [AuthController::class, 'process'])->name('super_admin.register');

    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('super.admin.dashboard');
    Route::resource('/shops', SuperAdminShopsController::class);
    Route::patch('/shops/{id}/toggle-status', [SuperAdminShopsController::class, 'toggleStatus'])->name('shops.toggleStatus');

});


// Frontend Routes for Multi-User Shops
Route::group(['prefix' => '{shop}', 'middleware' => 'identify.shop'], function () {
    Route::get('/', [UIController::class, 'index'])->name('store.home');
    // Route::get('/about', [UIController::class, 'about'])->name('store.about');
    Route::get('/contact', [UIController::class, 'contact'])->name('store.contact');
    Route::get('/shop', [UIController::class, 'shop'])->name('store.shop');

    Route::get('/products', [UIController::class, 'products'])->name('store.products');
    Route::get('/product/{slug}', [UIController::class, 'products'])->name('store.product.detail');

    Route::match(['get', 'post'], 'cart/add/{productId}', [CartController::class, 'addToCart'])->name('store.cart.add');
    Route::put('cart/update/{productId}', [CartController::class, 'updateCart'])->name('store.cart.update');
    Route::get('cart', [CartController::class, 'showCart'])->name('store.cart.show');
    Route::get('cart/remove/{productId}', [CartController::class, 'removeFromCart'])->name('store.cart.remove');

    Route::post('/proceed_checkout', [CartController::class, 'proceedCheckout'])->name('store.proceed_checkout')->middleware('signed');
    Route::post('/checkout', [CartController::class, 'Checkout'])->name('store.checkout');
    Route::post('/quick_checkout', [CartController::class, 'QuickCheckout'])->name('store.quick.checkout');

    Route::get('/collection/{collectionName}', [UIController::class, 'showCollection'])->name('store.collection');
    Route::post('/submit-contact', [UIController::class, 'storeContact'])->name('store.contact.submit');
    Route::get('/page/{page}', [UIController::class, 'showPage'])->name('store.pages.show');

    // Route::post('/apply_coupon', [CartController::class, 'applyCoupon'])->name('store.applyCoupon');

    Route::get('/thankyou', function () { return view('cart.thankyou'); })->name('store.thankyou');
});

// Store Admin Panel Routes for Multi-User Shops
Route::group(['prefix' => '{shop}/admin', 'middleware' => 'identify.shop'], function () {
    // Authentication Routes
    Route::get('/', [AuthController::class, 'index'])->name('admin.login')->middleware('guest');
    Route::post('/', [AuthController::class, 'authenticate']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth');
    Route::get('/register', [AuthController::class, 'register'])->name('admin.register');
    Route::post('/register', [AuthController::class, 'process'])->name('admin.register');

    // Protected Routes for Admin Panel
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('/barang', BarangController::class);
        Route::resource('/product', ProductsController::class);
        Route::post('/productUpdateStatus', [ProductsController::class, 'updateStatus'])->name('product.updateStatus');

        Route::resource('/orders', OrderController::class);
        Route::resource('/contact', ContactController::class);
        Route::resource('/collection', CollectionController::class);
        Route::post('/updateStatus', [CollectionController::class, 'updateStatus'])->name('collection.updateStatus');

        // Route::resource('/coupon', CouponController::class);
        // Route::post('/validate-coupon-code', [CouponController::class, 'validateCouponCode'])->name('coupon.validate');
        // Route::post('/updateStatus', [CouponController::class, 'updateStatus'])->name('coupon.updateStatus');

        Route::get('/pages', [StorePageController::class, 'index'])->name('pages.index');
        Route::get('/pages/edit/{page}', [StorePageController::class, 'edit'])->name('pages.edit');
        Route::post('/pages/update/{page}', [StorePageController::class, 'update'])->name('pages.update');

        Route::get('settings', [StoreSettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [StoreSettingController::class, 'store'])->name('settings.store');
        Route::get('/settings/homePage', [StoreSettingController::class, 'homePage'])->name('settings.homePage');
        Route::get('/settings/checkout_form', [StoreSettingController::class, 'checkout_form'])->name('settings.checkout_form');


    });
});



