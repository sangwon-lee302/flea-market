<x-app-layout class="flex w-[50%] max-w-2xl flex-col items-center pt-40">
    <p class="text-center text-2xl font-bold">登録していただいたメールアドレスに認証メールを送付しました。<br />
    メール認証を完了してください。</p>

    <a
        href="http://localhost:8025"
        target="_blank"
        rel="noopener noreferer"
        class="mt-12 rounded-md border bg-gray-300 px-6 py-4 font-bold"
        >認証はこちらから</a
    >

    <form
        action="{{ route('verification.send') }}"
        method="POST"
        class="mt-8 border-none bg-none text-blue-600 hover:underline"
    >
        @csrf
        <button class="cursor-pointer hover:underline">
            認証メールを再送する
        </button>
    </form>

    @if (session('status') == 'verification-link-sent')
        <p class="mt-8 rounded-full bg-green-300 p-2 text-green-700">認証メールを再送信しました</p>
    @endif
</x-app-layout>
