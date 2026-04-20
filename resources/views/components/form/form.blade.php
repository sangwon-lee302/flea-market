@props ([
    'title' => '',
    'method' => 'GET',
])

@php
    $method = strtoupper($method);
    $isGet = $method === 'GET';
    $shouldSpoofMethod = in_array($method, ['PUT', 'PATCH', 'DELETE']);
@endphp

<div>
    <h1 class="text-center text-4xl font-bold">{{ $title }}</h1>

    <form
        method="{{ $isGet ? 'GET' : 'POST' }}"
        {{ $attributes->merge(['class' => 'mt-12 flex flex-col']) }}
    >
        @if (! $isGet)
            @csrf
        @endif

        @if ($shouldSpoofMethod)
            @method ($method)
        @endif

        {{ $slot }}
    </form>
</div>
