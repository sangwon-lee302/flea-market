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
        class="sticky top-0 z-50 flex items-center justify-between gap-8 bg-black px-8 py-4 text-white"
    >
        <a
            href="{{ route('items.index') }}"
            class="max-w-[30%] items-center lg:h-9"
            ><img
                src="{{ asset('images/header_logo.png') }}"
                alt="COACHTECH フリマ"
                class="object-contain lg:h-9"
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
                    class="w-full truncate rounded-sm bg-white px-2 py-1 text-black lg:py-2"
                />
            </form>
            <nav
                class="flex items-center justify-between gap-4 text-sm lg:gap-6 lg:text-base"
            >
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="cursor-pointer text-center">
                            ログアウト
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-center"
                        >ログイン</a
                    >
                @endguest

                {{-- maybe it would be better to simply hide the mypage link for guests --}}
                {{-- but i have to meet the specs... --}}
                <a
                    href="{{ 
                        auth()->check()
                            ? route('profiles.show', ['profile' => auth()->user()->profile, 'page' => 'sell'])
                            : route('login')
                    }}"
                    class="text-center"
                    >マイページ</a
                >
                <a
                    href="{{ route('items.create') }}"
                    class="cursor-pointer rounded-xs bg-white px-2 py-1 text-center text-black lg:px-4"
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
