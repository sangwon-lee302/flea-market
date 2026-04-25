@props ([
    'item',
    'isLiked' => false,
])

<button
    id="like-button"
    type="button"
    onclick="toggleLike({{ $item->id }})"
    data-on-src="{{ asset('images/likes_on.png') }}"
    data-off-src="{{ asset('images/likes_off.png') }}"
    class="flex cursor-pointer flex-col items-center focus:outline-none"
>
    <img
        id="like-icon"
        src="{{ asset($isLiked ? 'images/likes_on.png' : 'images/likes_off.png') }}"
        alt="{{ $isLiked ? 'いいね済み' : 'いいね'}}"
        class="size-6"
    />
    <span id="like-count" class="font-semibold">{{ $item->likes_count }}</span>
</button>
