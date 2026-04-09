@props (['href' => '/'])

<a
    {{ $attributes->merge([
        'href' => $href,
        'class' => 'mx-auto text-blue-600 hover:underline',
    ]) }}
    >{{ $slot }}</a
>
