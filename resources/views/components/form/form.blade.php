@props ([
    'title' => null,
    'method' => 'GET',
])

@php
    $method = strtoupper($method);
    $isGet = $method === 'GET';
    $shouldSpoofMethod = in_array($method, ['PUT', 'PATCH', 'DELETE']);
@endphp

<div>
    @if ($title)
        <h1 class="mb-12 text-center text-4xl font-bold">{{ $title }}</h1>
    @endif

    <form
        method="{{ $isGet ? 'GET' : 'POST' }}"
        {{ $attributes->merge(['class' => 'flex flex-col']) }}
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
