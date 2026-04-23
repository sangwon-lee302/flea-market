<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_login_with_empty_email(): void
    {
        User::factory()->create();

        $this->get('/login')->assertOk();

        $response = $this->post('/login', [
            'email'    => '',
            'password' => 'password',
        ]);

        $this->assertGuest();

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    public function test_user_cannot_login_with_empty_password(): void
    {
        $user = User::factory()->create();

        $this->get('/login')->assertOk();

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => '',
        ]);

        $this->assertGuest();

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create();

        $this->get('/login')->assertOk();

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'invalid-password',
        ]);

        $this->assertGuest();

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email' => 'ログイン情報が登録されていません']);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create();

        $this->get('/login')->assertOk();

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect('/');
    }
}
