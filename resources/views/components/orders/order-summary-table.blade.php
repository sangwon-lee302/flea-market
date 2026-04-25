@props (['item'])

<table class="table-fixed border-collapse">
    <tbody>
        <tr class="border">
            <th class="w-1/2 p-8 font-normal">商品代金</th>
            <td class="w-1/2 p-8 text-xl">
                &yen;<span
                    class="pl-2 text-2xl"
                    >{{ number_format($item->price) }}</span
                >
            </td>
        </tr>
        <tr class="border">
            <th class="p-8 font-normal">支払い方法</th>
            <td
                id="payment-method-display"
                x-text="
                    $store.checkout.labels[$store.checkout.paymentMethod] ||
                    '(未選択)'
                "
                class="p-8 text-2xl"
                :class="{ 'text-gray-400': !$store.checkout.paymentMethod }"
            ></td>
        </tr>
    </tbody>
</table>
