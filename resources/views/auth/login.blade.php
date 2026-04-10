<x-auth
    title="ログイン"
    action="{{ route('login') }}"
    buttonText="ログインする"
    :anchorHref="route('register')"
    anchorText="会員登録はこちら"
>
    <x-form.input-field field="email" type="email" />
    <x-form.input-field field="password" type="password" />
</x-auth>
