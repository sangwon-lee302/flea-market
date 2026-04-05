@props (['field'])

<label for="{{ $field }}">{{ __("validation.attributes.$field") }}</label>
<input
    id="{{ $field }}"
    name="{{ $field }}"
    value="{{ old('field', '') }}"
    {{ $attributes->merge(['type' => 'text', 'class' => 'border mb-8 p-2 rounded-sm border-gray-500']) }}
/>
