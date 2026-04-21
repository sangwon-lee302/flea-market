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
        $orderData   = session('order_data', []);
        $addressData = session('temp_address', []);

        $profile = Auth::user()->profile;

        $paymentMethods = PaymentMethod::jsList();

        return view('orders.create', [
            'orderData'      => $orderData,
            'addressData'    => $addressData,
            'item'           => $item,
            'profile'        => $profile,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    /**
     * Redirect to the actual billing page with necessary information.
     */
    public function checkout(OrderRequest $request, Item $item)
    {
        $validated = $request->validated();

        session(['order_form_data' => $validated]);

        if ($request->action === 'edit_shipping_address') {
            return redirect()->route('shipping_addresses.edit', ['item' => $item]);
        }

        $checkout_url = Order::prepareCheckout($item, $validated['payment_method']);

        return redirect($checkout_url);
    }

    /**
     * Store a newly created resource in storage after successful checkout.
     */
    public function success(Item $item)
    {
        $orderData = session('order_form_data');

        Order::storeOrder(Auth::user(), $item, $orderData);

        session()->forget('order_form_data');

        return redirect()->route('items.index');
    }
}
