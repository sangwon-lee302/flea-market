@props ([
    'orderData' => [],
    'paymentMethods' => [],
])

<div {{ $attributes }}>
    <select
        x-model="$store.checkout.paymentMethod"
        name="payment_method"
        form="order_form"
        class="w-3xs rounded-sm border border-gray-500"
    >
        <option
            value=""
            disabled
            hidden
            @selected (! old('payment_method', $orderData['payment_method'] ?? null))
            >選択してください
        </option>
        @foreach ($paymentMethods as $value => $label)
            <option
                value="{{ $value }}"
                @selected (old('payment_method', $orderData['payment_method'] ?? null) == $value)
                >{{ $label }}
            </option>
        @endforeach
    </select>
    @error ('payment_method')
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
