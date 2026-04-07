<x-auth>
    <x-slot:title>
        会員登録
    </x-slot:title>

    <x-slot:formAction>
        {{ route('register') }}
    </x-slot:formAction>

    <x-form.label-input field="name" />
    <x-form.label-input field="email" type="email" />
    <x-form.label-input field="password" type="password" />
    <x-form.label-input field="password_confirmation" type="password" />

    <x-slot:buttonLabel>
        登録する
    </x-slot:buttonLabel>

    <x-slot:anchorHref>
        {{ route('login') }}
    </x-slot:anchorHref>
    <x-slot:anchorText>
        ログインはこちら
    </x-slot:anchorText>
</x-auth>
