<x-app-layout class="mt-8">
    <x-items.list-with-nav
        :items="$items"
        :links="[
            'おすすめ'   => ['name' => 'items.index', 'exclude' => ['tab']],
            'マイリスト' => ['name' => 'items.index', 'param' => ['tab' => 'mylist']],
        ]"
    />
</x-app-layout>
