<x-auth>
    <x-slot:title>
        ログイン
    </x-slot:title>

    <x-slot:formAction>
        {{ route('login') }}
    </x-slot:formAction>

    <x-form.label-input field="email" type="email" />
    <x-form.label-input field="password" type="password" />

    <x-slot:buttonLabel>
        ログインする
    </x-slot:buttonLabel>

    <x-slot:anchorHref>
        {{ route('register') }}
    </x-slot:anchorHref>
    <x-slot:anchorText>
        会員登録はこちら
    </x-slot:anchorText>
</x-auth>
