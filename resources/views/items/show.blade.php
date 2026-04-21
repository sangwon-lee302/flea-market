<x-app-layout class="mt-20 grid w-[90%] max-w-7xl grid-cols-1 lg:grid-cols-2">
    {{-- item image --}}
    <img
        src="{{ asset('storage/'.$item->image) }}"
        alt="商品画像"
        class="w-full max-w-100 rounded-xl p-4 lg:sticky lg:top-41 lg:aspect-square"
    />
    {{-- item detail --}}
    <div class="flex flex-col p-4">
        <h1 class="text-4xl font-bold">{{ $item->name }}</h1>
        <p class="text-sm">{{ $item->brand_name }}</p>
        <p class="mt-4 text-lg">&yen;<span class="text-3xl">{{ number_format($item->price) }}</span><span class="pl-2 text-xl">(税込)</span></p>
        {{-- likes/comments icons and number --}}
        <div class="flex gap-8 px-6 py-3">
            <x-like-button :item="$item" :is-liked="$isLiked" />
            <div class="flex flex-col items-center">
                <img
                    src="{{ asset('images/comments.png') }}"
                    alt="コメント"
                    class="size-6"
                />
                <span class="font-semibold">{{ $item->comments_count }}</span>
            </div>
        </div>
        <a
            href="{{ route('orders.create', ['item' => $item]) }}"
            class="btn btn-primary"
            >購入手続きへ</a
        >
        <h2 class="py-6 text-2xl font-bold">商品説明</h2>
        <p class="py-2 whitespace-pre-wrap">{{ $item->description }}</p>
        <h2 class="py-6 text-2xl font-bold">商品の情報</h2>
        {{-- item categories and condition --}}
        <table class="table-fixed">
            <tbody>
                <tr>
                    <th class="w-1/2 pb-6 text-left">カテゴリー</th>
                    <td class="flex w-1/2 flex-wrap gap-4 pb-6">
                        @foreach ($categories as $category)
                            <span
                                class="rounded-full bg-gray-300 px-4 text-black"
                                >{{ $category->name->label() }}</span
                            >
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th class="text-left">商品の状態</th>
                    <td>{{ $item->condition->label() }}</td>
                </tr>
            </tbody>
        </table>
        {{-- comments section --}}
        <h2 class="py-6 text-2xl font-bold text-gray-600">
            コメント({{ $item->comments_count }})
        </h2>
        @foreach ($item->comments as $comment)
            <div class="flex items-center gap-4 pb-4">
                <x-profile-image
                    :src="$comment->user->profile->avatar"
                    class="size-12"
                />
                <p class="text-2xl font-bold">{{ $comment->user->profile->nickname }}</p>
            </div>
            <p class="mb-8 rounded-sm bg-gray-300 px-2 py-4">{{ $comment->body }}</p>
        @endforeach
        {{-- comments creation section --}}
        <form
            action="{{ route('comments.store', ['item' => $item]) }}"
            method="POST"
            class="flex flex-col"
        >
            @auth
                <label>
                    <p class="pb-2 text-xl font-bold">商品へのコメント</p>
                    <textarea
                        name="body"
                        rows="10"
                        class="w-full rounded-sm border-2 border-gray-400 p-2"
                        >{{ old('body') }}</textarea
                    >
                    @error ('body')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </label>
            @endauth
            <button class="btn btn-primary mt-8">
                {{ auth()->check() ? 'コメントを送信する' : 'ログインしてコメントを入力'}}
            </button>
        </form>
    </div>
</x-app-layout>
