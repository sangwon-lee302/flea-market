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
        class="flex items-center justify-between bg-black px-4 py-6 text-white"
    >
        <img src="{{ asset('images/header_logo.png') }}" alt="Company Logo" />
    </header>

    <main {{ $attributes->merge(['class' => 'mx-auto min-h-full']) }}
        >{{ $slot }}
    </main>
</body>
</html>
