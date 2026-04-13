@props (['field' => ''])

<div class="flex flex-col">
    <label
        for="{{ $field }}"
        class="font-bold"
        >{{ __("validation.attributes.$field") }}</label
    >
    <input
        id="{{ $field }}"
        name="{{ $field }}"
        value="{{ old($field) }}"
        {{ $attributes->twMerge(['class' => 'border p-2 rounded-sm border-gray-500']) }}
    />
    @error ($field)
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>
