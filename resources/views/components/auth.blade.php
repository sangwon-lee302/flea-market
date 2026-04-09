@props ([
    'title' => '',
    'buttonText' => '',
    'anchorHref' => '/',
    'anchorText' => '',
])

<x-app-layout class="w-[75%] max-w-2xl pt-30">
    <x-form
        {{ $attributes->merge([
            'title' => $title,
            'method' => 'POST',
            'novalidate',
        ]) }}
    >
        <div class="flex flex-col gap-8">{{ $slot }}</div>

        <x-form.button class="mt-16">{{ $buttonText }}</x-form.button>
    </x-form>

    <x-anchor
        :href="$anchorHref"
        class="mt-8 block w-fit"
        >{{ $anchorText }}</x-anchor
    >
</x-app-layout>
