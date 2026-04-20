@props ([
    'title' => '',
    'buttonText' => '',
    'anchorHref' => '/',
    'anchorText' => '',
])

<x-app-layout class="w-[75%] max-w-2xl pt-30">
    <x-form title="{{ $title }}" method="POST" novalidate {{ $attributes }}>
        <div class="flex flex-col gap-8">{{ $slot }}</div>

        <x-form.button class="mt-16">{{ $buttonText }}</x-form.button>
    </x-form>

    <a
        href="{{ $anchorHref }}"
        class="anchor mx-auto mt-8 block w-fit"
        >{{ $anchorText }}</a
    >
</x-app-layout>
