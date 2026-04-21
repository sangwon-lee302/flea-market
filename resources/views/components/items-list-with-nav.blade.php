@props ([
    'items' => [],
    'links' => [],
])

<nav
    class="flex items-center gap-[4%] border-b-2 border-gray-500 px-[10%] py-2 font-bold text-gray-500"
>
    @foreach ($links as $label => $route)
        <a href="{{ $getRoute($route['name'], $route['param'] ?? []) }}">
            <span
                @class (['text-red-500' => $isActive($route['name'], $route['param'] ?? [])])
                >{{ $label }}</span
            >
        </a>
    @endforeach
</nav>
<div
    class="mx-auto mt-12 grid w-[95%] max-w-7xl grid-cols-3 gap-4 lg:grid-cols-4 lg:gap-12"
>
    @foreach ($items as $item)
        <a href="{{ route('items.show', $item) }}">
            <div class="relative">
                <img
                    src="{{ asset('storage/'.$item->image_path) }}"
                    alt="商品画像"
                    class="rounded-sm object-cover"
                />
                @if ($item->is_sold)
                    <div
                        class="absolute inset-0 flex items-center justify-center bg-gray-600/50 text-2xl text-white"
                    >
                        Sold
                    </div>
                @endif
            </div>
            <p>{{ $item->name }}</p>
        </a>
    @endforeach
</div>
