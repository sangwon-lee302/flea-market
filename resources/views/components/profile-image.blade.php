@props (['profile'])

<img
    src="{{ asset('storage/'.$profile->image_path) ?? '' }}"
    {{ $attributes->twMerge(['class' => 'h-37.5 w-37.5 rounded-full bg-gray-500 object-cover']) }}
/>
