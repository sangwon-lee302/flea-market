<x-app-layout class="w-[75%] max-w-2xl pt-30">
    <x-form
        title="住所の変更"
        :action="route('shipping_addresses.update', ['item' => $item])"
        method="POST"
        class="flex flex-col gap-8"
    >
        <x-form.input-field
            field="postal_code"
            :value="old('postal_code', $addressData['postal_code'] ?? $profile->postal_code)"
        />
        <x-form.input-field
            field="address"
            :value="old('address', $addressData['address'] ?? $profile->address)"
        />
        <x-form.input-field
            field="building"
            :value="old('building', $addressData['building'] ?? $profile->building)"
        />
        <x-form.button class="btn btn-primary mt-8">更新する</x-form.button>
    </x-form>
</x-app-layout>
