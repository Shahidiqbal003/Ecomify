<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
// use App\Models\Coupon;
use App\Models\Shop;
use App\Models\Order;
use Session;

class CartController extends Controller
{
    public function addToCart(Request $request, $shopname, $productId)
    {
        // Find the product from the database
        $product = Product::find($productId);

        if ($product) {
            $cart = Session::get('cart', []);

            $size = $request->input('size');
            $color = $request->input('color');
            $quantity = $request->input('quantity', 1);

            // Check stock
            $cartKey = $productId . '-' . $size . '-' . $color;
            $existingQuantity = isset($cart[$cartKey]) ? $cart[$cartKey]['quantity'] : 0;
            $totalQuantity = $existingQuantity + $quantity;

            if ($totalQuantity > $product->stock) {
                session()->flash('error', 'The requested quantity exceeds the available stock!');
                return back();
            }

            // Add to cart
            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += $quantity;
            } else {
                $cart[$cartKey] = [
                    'id' => $productId,
                    'name' => $product->title,
                    'price' => $product->price,
                    'cover_image_data' => $product->cover_image_data,
                    'size' => $size,
                    'color' => $color,
                    'quantity' => $quantity,
                ];
            }

            Session::put('cart', $cart);

            session()->flash('success', 'Product added to cart successfully!');

            return back();
        } else {
            session()->flash('error', 'Product not found!');
            return back();
        }
    }


    public function updateCart(Request $request, $shopname, $productId)
    {
        // Validate the quantity input
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Get the current cart from the session
        $cart = Session::get('cart', []);

        // Check if the product exists in the cart
        foreach ($cart as $key => $item) {
            if (strpos($key, $productId . '-') === 0) {
                // Find the product in the database
                $product = Product::find($productId);

                if (!$product) {
                    return redirect()->route('store.cart.show', ['shop' => request()->route('shop')])
                        ->with('error', 'Product not found!');
                }

                // Validate the stock
                $newQuantity = $request->quantity;
                if ($newQuantity > $product->stock) {
                    return redirect()->route('store.cart.show', ['shop' => request()->route('shop')])
                        ->with('error', 'Requested quantity exceeds available stock!');
                }

                // Update the quantity in the cart
                $cart[$key]['quantity'] = $newQuantity;
                Session::put('cart', $cart);

                return redirect()->route('store.cart.show', ['shop' => request()->route('shop')])
                    ->with('success', 'Cart updated successfully!');
            }
        }

        return redirect()->route('store.cart.show', ['shop' => request()->route('shop')])
            ->with('error', 'Product not found in cart!');
    }


    public function showCart()
    {
        // Get the cart from the session
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function removeFromCart($shopname, $productId)
    {
        // Get the cart from the session
        $cart = Session::get('cart', []);

        // Remove the item from the cart
        foreach ($cart as $key => $item) {
            if (strpos($key, $productId . '-') === 0) {
                unset($cart[$key]);
                Session::put('cart', $cart);
                break;
            }
        }

        return redirect()->route('store.cart.show', ['shop' => request()->route('shop')]);
    }

    public function proceedCheckout(Request $request)
    {
        $cart = Session::get('cart', []);

        // Check if cart is empty
        if (empty($cart)) {
            return redirect()->route('store.cart.show', ['shop' => request()->route('shop')])
                ->with('error', 'Your cart is empty!');
        }

        // Validate stock for each item in the cart
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product) {
                return redirect()->route('store.cart.show', ['shop' => request()->route('shop')])
                    ->with('error', 'Product not found: ' . $item['name']);
            }

            if ($product->stock < $item['quantity']) {
                return redirect()->route('store.cart.show', ['shop' => request()->route('shop')])
                    ->with('error', 'Insufficient stock for product: ' . $item['name']);
            }
        }

        $subtotal = floatval(str_replace(',', '', $request->input('total')));
        $shipping = number_format('300', 2);
        $total = $shipping + $subtotal;

        if (!$request->hasValidSignature()) {
            abort(404);
        }

        return view('cart.checkout', compact('cart', 'subtotal', 'shipping', 'total'));
    }


    public function Checkout(Request $request, $shop)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty!');
        }

        // Validate general order information
        $validatedData = $request->validate([
            'email' => 'required|email',
            'news_offers' => 'nullable',
            'country' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'company' => 'nullable',
            'address' => 'required',
            'apartment' => 'nullable',
            'city' => 'required',
            'postal_code' => 'nullable',
            'phone' => 'required',
            'save_info' => 'nullable',
            'shipping' => 'required',
            'payment_method' => 'nullable',
            'note' => 'nullable',
        ]);

        $validatedData['shop_id'] = $shop->id;

        // Calculate totals
        $subTotal = 0;
        foreach ($cart as $item) {
            $subTotal += $item['price'] * $item['quantity'];
        }

        $shippingCharges = $request->input('shipping', 0);
        $totalPayment = $subTotal + $shippingCharges;

        // Add subtotal, total payment, and shipping charges
        $validatedData['sub_total'] = $subTotal;
        $validatedData['total_payment'] = $totalPayment;
        $validatedData['order_data'] = json_encode($cart);

        // Generate dynamic order serial
        $lastOrder = Order::where('shop_id', $shop->id)->latest('id')->first();
        $lastSerial = $lastOrder ? intval(str_replace('#', '', $lastOrder->order_serial)) : 0;
        $newSerial = str_pad($lastSerial + 1, 4, '0', STR_PAD_LEFT); // Generate new serial like #0001
        $validatedData['order_serial'] = '#' . $newSerial;

        // Save the order
        $order = Order::create($validatedData);

        // Update stock in products table
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $product->stock -= $item['quantity'];
                $product->save();
            }
        }

        // Clear the cart session
        Session::forget('cart');

        return redirect()->route('store.thankyou', ['shop' => $shop->name]);
    }

    public function QuickCheckout(Request $request, $shop)
    {
        // Fetch the shop by its name
        $shop = Shop::where('name', $shop)->firstOrFail();

        // Extract product data from the request
        $productData = $request->only(['id', 'name', 'price', 'cover_image_data', 'size', 'color', 'quantity']);
        $productId = $productData['id'];
        $size = $productData['size'] ?? '';
        $color = $productData['color'] ?? '';
        $quantity = intval($productData['quantity'] ?? 1);

        // Fetch the product from the database
        $product = Product::find($productId);

        // Check if the product exists and stock is sufficient
        if (!$product || $product->stock < $quantity) {
            return back()->with('error', 'Insufficient stock available for the selected product.');
        }

        // Create the array with the specified key format
        $formattedProductKey = $productId . '-' . $size . '-' . $color;
        $productArray = [
            $formattedProductKey => $productData,
        ];

        // Calculate totals
        $subTotal = $productData['price'] * $quantity;
        $shippingCharges = $request->input('shipping', 0);
        $totalPayment = $subTotal + $shippingCharges;

        // Prepare order data
        $validatedData = $request->only([
            'email', 'news_offers', 'country', 'first_name', 'last_name', 'company',
            'address', 'apartment', 'city', 'postal_code', 'phone', 'note',
        ]);

        $validatedData['shop_id'] = $shop->id;
        $validatedData['sub_total'] = $subTotal;
        $validatedData['total_payment'] = $totalPayment;
        $validatedData['shipping'] = $shippingCharges;
        $validatedData['payment_method'] = 'COD';
        $validatedData['order_data'] = json_encode($productArray);

        // Generate dynamic order serial
        $lastOrder = Order::where('shop_id', $shop->id)->latest('id')->first();
        $lastSerial = $lastOrder ? intval(str_replace('#', '', $lastOrder->order_serial)) : 0;
        $newSerial = str_pad($lastSerial + 1, 4, '0', STR_PAD_LEFT); // Generate new serial like #0001
        $validatedData['order_serial'] = '#' . $newSerial;

        // Save the order
        $order = Order::create($validatedData);

        // Update product stock
        $product->stock -= $quantity;
        $product->save();

        // Redirect to thank you page
        return redirect()->route('store.thankyou', ['shop' => $shop->name]);
    }

    // public function applyCoupon(Request $request, $shop)
    // {
    //     $couponCode = $request->input('coupon_code');
    //     $cartTotal = $request->input('cart_total'); // Cart ka total price

    //     // Find shop
    //     $shop = Shop::where('name', $shop)->firstOrFail();

    //     // Find coupon
    //     $coupon = Coupon::where('shop_id', $shop->id)
    //                     ->where('code', $couponCode)
    //                     ->first();

    //     if (!$coupon) {
    //         return response()->json(['success' => false, 'message' => 'Invalid coupon code.']);
    //     }

    //     // Check coupon expiry
    //     if ($coupon->expiry_date < now()) {
    //         return response()->json(['success' => false, 'message' => 'Coupon has expired.']);
    //     }

    //     // Check if coupon is active
    //     if ($coupon->status != 1) {
    //         return response()->json(['success' => false, 'message' => 'Coupon is inactive.']);
    //     }

    //     // Check if coupon is available
    //     if ($coupon->qty <= 0) {
    //         return response()->json(['success' => false, 'message' => 'Coupon is no longer available.']);
    //     }

    //     // Apply discount if coupon type is "percentage"
    //     $discountAmount = 0;

    //     if ($coupon->discount_type == "percentage") {
    //         $discountAmount = ($cartTotal * $coupon->discount_value) / 100;
    //     }

    //     // Calculate new total after discount
    //     $newTotal = $cartTotal - $discountAmount;

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Coupon applied successfully!',
    //         'discount_amount' => $discountAmount,
    //         'new_total' => $newTotal
    //     ]);
    // }

}
