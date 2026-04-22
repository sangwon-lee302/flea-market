@props ([
    'field' => '',
    'label' => null,
    'value' => '',
])

<div class="flex flex-col">
    <label
        for="{{ str($field)->kebab() }}"
        class="font-bold"
        >{{ $label ?? __("validation.attributes.$field") }}</label
    >
    <div class="relative">
        @if ($slot)
            <span
                class="absolute top-1/2 left-2 -translate-y-1/2 font-bold"
                >{{ $slot }}</span
            >
        @endif
        <input
            id="{{ str($field)->kebab() }}"
            name="{{ $field }}"
            value="{{ old($field, $value) }}"
            {{ $attributes->merge(['class' => 'w-full p-2 rounded-sm border border-gray-500']) }}
        />
    </div>
    @error ($field)
        <span class="text-red-500">{{ $message }}</span>
    @enderror
</div>
