<x-auth
    title="ログイン"
    action="{{ route('login') }}"
    button-text="ログインする"
    :anchor-href="route('register')"
    anchor-text="会員登録はこちら"
>
    <x-form.input-field field="email" type="email" />
    <x-form.input-field field="password" type="password" />
</x-auth>
