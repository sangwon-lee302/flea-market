<?php

namespace Tests\Feature\Auths;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_email_is_sent_upon_registration(): void
    {
        Notification::fake();

        $user     = User::factory()->unverified()->make();
        $password = 'password123';

        $this->get('/register')->assertOk();

        $this->followingRedirects()
            ->post('/register', [
                'name'                  => $user->name,
                'email'                 => $user->email,
                'password'              => $password,
                'password_confirmation' => $password,
            ])
            ->assertOk();

        Notification::assertSentTo(
            User::where('email', $user->email)->first(),
            VerifyEmail::class
        );
    }

    public function test_user_is_redirected_to_mailpit_dashboard(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->get(route('verification.notice'))
            ->assertOk()
            ->assertSee('http://localhost:8025');
    }

    public function test_user_is_redirected_to_profile_edit_page_after_verifying_email(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->actingAs($user)
            ->followingRedirects()
            ->get($verificationUrl)
            ->assertOk()
            ->assertViewIs('profiles.edit');
    }
}
