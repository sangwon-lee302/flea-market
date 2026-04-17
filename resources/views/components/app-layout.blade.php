<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>COACHTECH フリマ</title>
    @vite (['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header
        class="sticky top-0 flex items-center justify-between bg-black px-8 py-4 text-white"
    >
        <img src="{{ asset('images/header_logo.png') }}" alt="Company Logo" />

        @unless (request()->routeIs(['login', 'register', 'verification.*']))
            <nav class="flex items-center justify-between gap-4">
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
            </nav>
        @endunless
    </header>

    <main {{ $attributes->merge(['class' => 'mx-auto pb-30 min-h-full']) }}
        >{{ $slot }}
    </main>
</body>
</html>
