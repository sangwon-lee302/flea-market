<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Http\Requests\OrderRequest;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Item $item)
    {
        $orderData = session('order_data', []);

        $shippingAddress = session('shipping_address', []);

        $profile = auth()->user()->profile;

        $paymentMethods = PaymentMethod::jsList();

        return view('orders.create', [
            'orderData'       => $orderData,
            'shippingAddress' => $shippingAddress,
            'item'            => $item,
            'profile'         => $profile,
            'paymentMethods'  => $paymentMethods,
        ]);
    }

    /**
     * Redirect to the actual billing page with necessary information.
     */
    public function checkout(OrderRequest $request, Item $item)
    {
        $validated = $request->validated();

        session(['validated_order_data' => $validated]);

        session()->forget('order_data');

        $checkout_url = Order::prepareCheckout($item, auth()->user(), $validated['payment_method']);

        return redirect($checkout_url);
    }

    /**
     * Store a newly created resource in storage after successful checkout.
     */
    public function success(Request $request, Item $item)
    {
        $user = auth()->user();

        abort_unless(Order::isPaidFor($request->query('session_id'), $item, $user), 403);

        $orderData = session('validated_order_data');

        abort_if(blank($orderData), 403);

        Order::storeOrder($user, $item, $orderData);

        session()->forget('validated_order_data');

        return redirect()->route('items.index');
    }
}
