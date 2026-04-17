@props (['href' => '/'])

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'mx-auto text-blue-600 cursor-pointer hover:underline']) }}
    >{{ $slot }}</a
>
