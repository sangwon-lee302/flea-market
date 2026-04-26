<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingAddressRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class ShippingAddressSessionController extends Controller
{
    /**
     * Show the form for editing a shipping address.
     */
    public function edit(Request $request, Item $item)
    {
        session(['order_data' => $request->all()]);

        $shippingAddress = session('shipping_address', []);

        $profile = auth()->user()->profile;

        return view('address.edit', [
            'shippingAddress' => $shippingAddress,
            'item'            => $item,
            'profile'         => $profile,
        ]);
    }

    /**
     * Update a shipping address.
     */
    public function update(ShippingAddressRequest $request, Item $item)
    {
        $validated = $request->validated();

        session(['shipping_address' => $validated]);

        return redirect()->route('orders.create', ['item' => $item]);
    }
}
