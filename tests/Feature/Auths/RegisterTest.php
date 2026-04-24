<?php

namespace Tests\Feature\Auths;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_register_with_empty_name(): void
    {
        $user     = User::factory()->make();
        $password = 'password123';

        $this->get('/register')->assertOk();

        $response = $this->post('/register', [
            'name'                  => '',
            'email'                 => $user->email,
            'password'              => $password,
            'password_confirmation' => $password,
        ]);

        $this->assertDatabaseMissing('users', ['email' => $user->email]);

        $this->assertGuest();

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name' => 'お名前を入力してください']);
    }

    public function test_user_cannot_register_with_empty_email(): void
    {
        $user     = User::factory()->make();
        $password = 'password123';

        $this->get('/register')->assertOk();

        $response = $this->post('/register', [
            'name'                  => $user->name,
            'email'                 => '',
            'password'              => $password,
            'password_confirmation' => $password,
        ]);

        $this->assertDatabaseMissing('users', ['name' => $user->name]);

        $this->assertGuest();

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    public function test_user_cannot_register_with_empty_password(): void
    {
        $user = User::factory()->make();

        $this->get('/register')->assertOk();

        $response = $this->post('/register', [
            'name'                  => $user->name,
            'email'                 => $user->email,
            'password'              => '',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseMissing('users', ['email' => $user->email]);

        $this->assertGuest();

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    public function test_user_cannot_register_with_short_password(): void
    {
        $user          = User::factory()->make();
        $shortPassword = '1234567';

        $this->get('/register')->assertOk();

        $response = $this->post('/register', [
            'name'                  => $user->name,
            'email'                 => $user->email,
            'password'              => $shortPassword,
            'password_confirmation' => $shortPassword,
        ]);

        $this->assertDatabaseMissing('users', ['email' => $user->email]);

        $this->assertGuest();

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);
    }

    public function test_user_cannot_register_with_unconfirmed_password(): void
    {
        $user = User::factory()->make();

        $this->get('/register')->assertOk();

        $response = $this->post('/register', [
            'name'                  => $user->name,
            'email'                 => $user->email,
            'password'              => 'password',
            'password_confirmation' => 'different-password',
        ]);

        $this->assertDatabaseMissing('users', ['email' => $user->email]);

        $this->assertGuest();

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password_confirmation' => 'パスワードと一致しません']);
    }

    public function test_user_can_register_with_valid_input(): void
    {
        // mark the user's email as verified as soon as user registration event is triggered in order to skip verification processes in this test
        // verification processes will be tested elsewhere
        Event::listen(Registered::class, function ($event) {
            $event->user->markEmailAsVerified();
        });

        $user     = User::factory()->make();
        $password = 'password123';

        $this->get('/register')->assertOk();

        $response = $this->followingRedirects()->post('/register', [
            'name'                  => $user->name,
            'email'                 => $user->email,
            'password'              => $password,
            'password_confirmation' => $password,
        ]);

        $this->assertDatabaseHas('users', ['email' => $user->email]);

        $registeredUser = User::where('email', $user->email)->first();

        $this->assertAuthenticatedAs($registeredUser);

        // check if a corresponding profile resource was created for the newly registered user
        $this->assertNotNull($registeredUser->profile);

        $this->assertEquals(url('/mypage/profile/'.$registeredUser->profile->id), request()->url());

        $response->assertOk();
    }
}
