@props (['title', 'route'])

<x-app-layout class="w-[75%] max-w-2xl pt-40">
    <h1 class="text-center text-4xl font-bold">{{ $title }}</h1>

    <form
        action="{{ $formAction }}"
        method="POST"
        class="mt-12 flex flex-col"
        novalidate
    >
        @csrf
        {{ $slot }}

        <x-form.button>{{ $buttonLabel }}</x-form.button>

        <a
            href="{{ $anchorHref }}"
            class="mx-auto mt-8 text-blue-600 hover:underline"
            >{{ $anchorText }}</a
        >
    </form>
</x-app-layout>
