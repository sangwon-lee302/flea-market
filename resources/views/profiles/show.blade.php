<x-app-layout>
    <div
        class="mx-auto flex w-[90%] max-w-5xl items-center justify-between py-15"
    >
        <div class="flex items-center gap-8 lg:gap-24">
            <x-profile-image :src="$profile->avatar" class="size-37.5" />
            <p class="text-2xl font-bold">{{ $profile->nickname }}</p>
        </div>
        <a
            href="{{ route('profiles.edit', $profile) }}"
            class="btn btn-secondary"
            >プロフィールを編集</a
        >
    </div>
    <x-items-list-with-nav
        :items="$items"
        :links="[
            '出品した商品' => ['name' => 'profiles.show', 'param' => ['profile' => $profile, 'page' => 'sell']],
            '購入した商品' => ['name' => 'profiles.show', 'param' => ['profile' => $profile, 'page' => 'buy']],
        ]"
    />
</x-app-layout>
