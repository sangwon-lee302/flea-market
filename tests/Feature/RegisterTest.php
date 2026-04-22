<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_register_with_empty_name(): void
    {
        $response = $this->get('/register');
        $response->assertOk();

        $response = $this->post('/register', [
            'name'                  => '',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/register');
        $response->assertInvalid(['name' => 'お名前を入力してください']);
    }

    public function test_user_cannot_register_with_empty_email(): void
    {
        $response = $this->get('/register');
        $response->assertOk();

        $response = $this->post('/register', [
            'name'                  => 'taro yamada',
            'email'                 => '',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/register');
        $response->assertInvalid(['email' => 'メールアドレスを入力してください']);
    }

    public function test_user_cannot_register_with_empty_password(): void
    {
        $response = $this->get('/register');
        $response->assertOk();

        $response = $this->post('/register', [
            'name'                  => 'taro yamada',
            'email'                 => 'test@example.com',
            'password'              => '',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/register');
        $response->assertInvalid(['password' => 'パスワードを入力してください']);
    }

    public function test_user_cannot_register_with_short_password(): void
    {
        $response = $this->get('/register');
        $response->assertOk();

        $response = $this->post('/register', [
            'name'                  => 'taro yamada',
            'email'                 => 'test@example.com',
            'password'              => '1234567',
            'password_confirmation' => '1234567',
        ]);

        $response->assertRedirect('/register');
        $response->assertInvalid(['password' => 'パスワードは8文字以上で入力してください']);
    }

    public function test_user_cannot_register_with_unconfirmed_password(): void
    {
        $response = $this->get('/register');
        $response->assertOk();

        $response = $this->post('/register', [
            'name'                  => 'taro yamada',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertRedirect('/register');
        $response->assertInvalid(['password' => 'パスワードと一致しません']);
    }

    public function test_user_can_register_with_valid_input(): void
    {
        $response = $this->get('/register');
        $response->assertOk();

        $response = $this->followingRedirects()->post('/register', [
            'name'                  => 'taro yamada',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'name'  => 'taro yamada',
            'email' => 'test@example.com',
        ]);
        $user = User::whereEmail('test@example.com')->first();
        $this->assertTrue(Hash::check('password', $user->password));
        $this->assertNotNull($user->profile);

        $this->assertAuthenticatedAs($user);

        $this->assertEquals(url('/email/verify'), request()->url());
        $response->assertOk();

        $verificationURL = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinute(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        $response = $this->get($verificationURL);

        $response->assertRedirect('/mypage/profile/'.$user->profile->id);

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
