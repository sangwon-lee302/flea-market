@props ([
    'field' => '',
    'value' => '',
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
        {{ $attributes->merge(['class' => 'p-2 rounded-sm border border-gray-500']) }}
    />
    @error ($field)
        <span class="text-red-500">{{ $message }}</span>
    @enderror
</div>
