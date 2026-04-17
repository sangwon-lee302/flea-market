@props (['src' => 'avatars/default.jpg'])

<img
    src="{{ asset('storage/'.$src) }}"
    alt="プロフィール画像"
    {{ $attributes->merge(['class' => 'h-37.5 w-37.5 rounded-full object-cover']) }}
/>
