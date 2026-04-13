@props ([
    'field' => '',
    'value' => null,
])

<div class="flex flex-col">
    <label
        for="{{ str($field)->kebab() }}"
        class="font-bold"
        >{{ __("validation.attributes.$field") }}</label
    >
    <input
        id="{{ str($field)->kebab() }}"
        name="{{ $field }}"
        value="{{ old($field, $value) }}"
        {{ $attributes->twMerge(['class' => 'border p-2 rounded-sm border-gray-500']) }}
    />
    @error ($field)
        <div class="text-red-500">{{ $message }}</div>
    @enderror
</div>
