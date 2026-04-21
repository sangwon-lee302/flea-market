<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingAddressRequest;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    /**
     * Show the form for editing a shipping address.
     */
    public function editSession(Item $item)
    {
        $addressData = session('temp_address', []);

        $profile = Auth::user()->profile;

        return view('address.edit', [
            'addressData' => $addressData,
            'item'        => $item,
            'profile'     => $profile,
        ]);
    }

    /**
     * Update a shipping address.
     */
    public function updateSession(ShippingAddressRequest $request, Item $item)
    {
        $validated = $request->validated();

        session(['temp_address' => $validated]);

        return redirect()->route('orders.create', ['item' => $item]);
    }
}
