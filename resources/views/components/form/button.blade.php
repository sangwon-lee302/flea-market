@props ([
    'variant' => 'primary',
])

@php
    $baseClasses = 'p-2 cursor-pointer transition-colors';

    $variants = [
        'primary' => 'bg-red-500 rounded-sm text-white hover:bg-red-400',
        'outline' => 'bg-white rounded-md text-red-500 hover:bg-red-50',
    ];
@endphp

<button
    {{ $attributes->twMerge(['class' => $baseClasses.' '.$variants[$variant]]) }}
    >{{ $slot }}
</button>
