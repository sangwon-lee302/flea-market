@props (['src' => 'avatars/default.jpg'])

<img
    src="{{ asset('storage/'.$src) }}"
    alt="プロフィール画像"
    {{ $attributes->merge(['class' => 'rounded-full object-cover']) }}
/>
