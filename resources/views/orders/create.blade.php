<template id="payment-methods-data" hidden>@json ($paymentMethods)</template>
<x-app-layout
    x-data
    x-init="$store.checkout.initData({
        paymentMethod: '{{ old('payment_method', $orderData['payment_method'] ?? '') }}',
        labels: JSON.parse(
            document.getElementById('payment-methods-data').innerHTML,
        )
    })"
    class="grid w-[90%] max-w-7xl grid-cols-1 gap-12 pt-25 lg:grid-cols-2"
>
    {{-- order detail section --}}
    <div class="flex flex-col">
        {{-- item info --}}
        <div class="flex gap-16 border-b pb-20">
            <img
                src="{{ asset('storage/'.$item->image) }}"
                alt="商品画像"
                class="size-50 rounded-xs"
            />
            <div>
                <h1 class="text-3xl font-bold">{{ $item->name }}</h1>
                <p class="pt-8 text-xl">&yen;<span class="pl-2 text-2xl">{{ number_format($item->price) }}</span></p>
            </div>
        </div>
        {{-- payment method --}}
        <div class="border-b px-12 py-8">
            <h2 class="pb-16 text-xl font-bold">支払い方法</h2>
            <x-orders.payment-method-select
                :order-data="$orderData"
                :payment-methods="$paymentMethods"
                class="ml-30"
            />
        </div>
        {{-- shipping address --}}
        <div class="border-b px-12 py-8">
            <div class="flex justify-between pb-16">
                <h2 class="text-xl font-bold">配送先</h2>
                <button
                    form="order_form"
                    formaction="{{ route('shipping_addresses.edit', $item) }}"
                    class="anchor"
                >
                    変更する
                </button>
            </div>
            <p class="text-lg font-semibold">&#12306; {{ $shippingAddress['postal_code'] ?? $profile->postal_code }}</p>
            <p class="text-lg font-semibold">{{ $shippingAddress['address'] ?? $profile->address }}{{ $shippingAddress['building'] ?? $profile->building }}</p>
        </div>
    </div>
    {{-- order summary & submit section --}}
    <div class="flex flex-col">
        <x-orders.order-summary-table :item="$item" />
        <form
            action="{{ route('orders.checkout', ['item' => $item]) }}"
            id="order_form"
            method="POST"
        >
            @csrf
            <button class="btn btn-primary mt-12 w-full">購入する</button>
        </form>
    </div>
</x-app-layout>
