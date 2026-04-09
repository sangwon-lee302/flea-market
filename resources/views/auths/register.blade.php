<x-auth
    title="会員登録"
    action="{{ route('register') }}"
    buttonText="登録する"
    :anchorHref="route('login')"
    anchorText="ログインはこちら"
>
    <x-form.input-field field="name" />
    <x-form.input-field field="email" type="email" />
    <x-form.input-field field="password" type="password" />
    <x-form.input-field field="password_confirmation" type="password" />
</x-auth>
