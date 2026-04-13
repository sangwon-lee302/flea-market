@props (['href' => '/'])

<a
    href="{{ $href }}"
    {{ $attributes->twMerge(['class' => 'cursor-pointer mx-auto text-blue-600 hover:underline']) }}
    >{{ $slot }}</a
>
