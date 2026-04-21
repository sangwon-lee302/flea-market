<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingAddressRequest;
use App\Models\Item;

class ShippingAddressController extends Controller
{
    /**
     * Show the form for editing a shipping address.
     */
    public function editSession(Item $item)
    {
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
    public function updateSession(ShippingAddressRequest $request, Item $item)
    {
        $validated = $request->validated();

        session(['shipping_address' => $validated]);

        return redirect()->route('orders.create', ['item' => $item]);
    }
}
