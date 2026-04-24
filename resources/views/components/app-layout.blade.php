<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>COACHTECH フリマ</title>
    @vite (['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <header
        class="sticky top-0 z-50 flex items-center justify-between bg-black px-8 py-4 text-white"
    >
        <a href="{{ route('items.index') }}"
            ><img
                src="{{ asset('images/header_logo.png') }}"
                alt="COACHTECH フリマ"
                class="h-9"
        /></a>

        @unless (request()->routeIs(['login', 'register', 'verification.*']))
            <form
                action="{{ route('items.index') }}"
                method="GET"
                class="w-[30%]"
            >
                @foreach (request()->query() as $key => $value)
                    @if ($key !== 'keyword')
                        <input
                            type="hidden"
                            name="{{ $key }}"
                            value="{{ $value }}"
                        />
                    @endif
                @endforeach
                <label for="search" class="sr-only">検索する商品名</label>
                <input
                    id="search"
                    type="search"
                    placeholder="なにをお探しですか？"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    class="w-full rounded-sm bg-white p-2 text-black"
                />
            </form>
            <nav class="flex items-center justify-between gap-6">
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="cursor-pointer">ログアウト</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}">ログイン</a>
                @endguest

                {{-- maybe it would be better to simply hide the mypage link for guests --}}
                {{-- but i have to meet the specs... --}}
                <a
                    href="{{ 
                        auth()->check()
                            ? route('profiles.show', ['profile' => auth()->user()->profile, 'page' => 'sell'])
                            : route('login')
                    }}"
                    >マイページ</a
                >
                <a
                    href="{{ route('items.create') }}"
                    class="cursor-pointer rounded-xs bg-white px-4 py-1 text-black"
                    >出品</a
                >
            </nav>
        @endunless
    </header>

    <main {{ $attributes->merge(['class' => 'mx-auto pb-30 min-h-full']) }}
        >{{ $slot }}
    </main>
</body>
</html>
