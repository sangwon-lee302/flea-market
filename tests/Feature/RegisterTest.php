<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_cannot_register_with_invalid_name(): void
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
}
