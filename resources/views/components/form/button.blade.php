<button
    {{ $attributes->merge([
    'class' => 'p-2 text-white bg-red-500 rounded-sm cursor-pointer hover:bg-red-400'
    ]) }}
    >{{ $slot }}
</button>
