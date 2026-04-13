<x-auth
    title="会員登録"
    action="{{ route('register') }}"
    button-text="登録する"
    :anchor-href="route('login')"
    anchor-text="ログインはこちら"
>
    <x-form.input-field field="name" />
    <x-form.input-field field="email" type="email" />
    <x-form.input-field field="password" type="password" />
    <x-form.input-field field="password_confirmation" type="password" />
</x-auth>
