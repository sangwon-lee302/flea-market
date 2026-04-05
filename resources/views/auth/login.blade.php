<x-app-layout class="w-[75%] max-w-150">
    <h1 class="mt-40 text-center text-4xl font-bold">ログイン</h1>

    <form
        action="{{ route('login') }}"
        method="POST"
        class="mt-12 flex flex-col"
        novalidate
    >
        @csrf
        <x-form.label-input field="email" />
        <x-form.label-input field="password" />

        <x-form.button>ログインする</x-form.button>

        <a
            href="{{ route('register') }}"
            class="mx-auto mt-8 text-blue-600 hover:underline"
            >会員登録はこちら</a
        >
    </form>
</x-app-layout>
