<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_register_with_empty_name(): void
    {
        $response = $this->get(route('register'));
        $response->assertOk();

        $response = $this->post(route('register.store'), [
            'name'                  => '',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertInvalid(['name' => 'お名前を入力してください']);
    }

    public function test_user_cannot_register_with_empty_email(): void
    {
        $response = $this->get(route('register'));
        $response->assertOk();

        $response = $this->post(route('register.store'), [
            'name'                  => 'taro yamada',
            'email'                 => '',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertInvalid(['email' => 'メールアドレスを入力してください']);
    }
}
