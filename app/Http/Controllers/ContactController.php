<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Shop;
use Illuminate\Http\Request;
use Session;

class ContactController extends Controller
{
    /**
     * Display a listing of the orders for the shop.
     */
    public function index($shop)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();
        $contacts = Contact::where('shop_id', $shop->id)->latest()->get();

        return view('contact.index', compact('contacts', 'shop'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create($shop)
    {

    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request, $shop)
    {

    }

    /**
     * Display the specified order.
     */
    public function show($shop, $id)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();
        $order = Order::where('shop_id', $shop->id)->findOrFail($id);

        return view('orders.show', compact('order', 'shop'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit($shop, $id)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();
        $order = Order::where('shop_id', $shop->id)->findOrFail($id);

        return view('orders.edit', compact('order', 'shop'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, $shop, $id)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();

        $order = Order::where('shop_id', $shop->id)->findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|integer|between:0,5',
        ]);

        $order->update(['status' => $validatedData['status']]);

        return redirect()->route('orders.index', ['shop' => $shop->name])
                        ->with('success', 'Order status updated successfully!');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($shop, $id)
    {
        $shop = Shop::where('name', $shop)->firstOrFail();
        $order = Order::where('shop_id', $shop->id)->findOrFail($id);

        $order->delete();

        return redirect()->route('orders.index', ['shop' => $shop->name])
                         ->with('success', 'Order deleted successfully!');
    }
}
