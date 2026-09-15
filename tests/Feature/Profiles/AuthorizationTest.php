<?php

namespace Tests\Feature\Profiles;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_view_another_users_mypage(): void
    {
        $user      = User::factory()->withProfileCompleted()->create();
        $otherUser = User::factory()->withProfileCompleted()->create();

        $this->actingAs($user)
            ->get(route('profiles.show', $otherUser->profile))
            ->assertForbidden();
    }

    public function test_user_cannot_open_another_users_profile_edit_form(): void
    {
        $user      = User::factory()->withProfileCompleted()->create();
        $otherUser = User::factory()->withProfileCompleted()->create();

        $this->actingAs($user)
            ->get(route('profiles.edit', $otherUser->profile))
            ->assertForbidden();
    }

    public function test_user_cannot_update_another_users_profile(): void
    {
        $user      = User::factory()->withProfileCompleted()->create();
        $otherUser = User::factory()->withProfileCompleted()->create();

        $victimProfile = $otherUser->profile;

        $this->actingAs($user)
            ->patch(route('profiles.update', $victimProfile), [
                'nickname'    => '乗っ取り',
                'postal_code' => '999-9999',
                'address'     => '東京都新宿区9-9-9',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('profiles', [
            'id'          => $victimProfile->id,
            'nickname'    => $victimProfile->nickname,
            'postal_code' => $victimProfile->postal_code,
            'address'     => $victimProfile->address,
        ]);
    }

    public function test_user_can_view_their_own_mypage(): void
    {
        $user = User::factory()->withProfileCompleted()->create();

        $this->actingAs($user)
            ->get(route('profiles.show', $user->profile))
            ->assertOk();
    }

    public function test_user_can_update_their_own_profile(): void
    {
        $user = User::factory()->withProfileCompleted()->create();

        $this->actingAs($user)
            ->patch(route('profiles.update', $user->profile), [
                'nickname'    => '新しい名前',
                'postal_code' => '123-4567',
                'address'     => '東京都渋谷区1-2-3',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('profiles', [
            'id'       => $user->profile->id,
            'nickname' => '新しい名前',
        ]);
    }
}
