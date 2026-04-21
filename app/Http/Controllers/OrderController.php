<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Item;
use App\Models\Order;
use App\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Item $item)
    {
        $formData    = session('order_form_data', []);
        $addressData = session('temp_address', []);

        $profile = Auth::user()->profile;

        $paymentMethods = PaymentMethod::jsList();

        return view('orders.create', [
            'formData'       => $formData,
            'addressData'    => $addressData,
            'item'           => $item,
            'profile'        => $profile,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request, Item $item)
    {
        $validated = $request->validated();

        session(['order_form_data' => $validated]);

        if ($request->action === 'edit_shipping_address') {
            return redirect()->route('shipping_addresses.edit', ['item' => $item]);
        }

        Order::storeOrder(Auth::user(), $item, $validated);

        session()->forget('order_form_data');

        return redirect()->route('items.index');
    }
}
