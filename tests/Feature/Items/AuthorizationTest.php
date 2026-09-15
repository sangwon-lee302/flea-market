<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_like_their_own_item(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->recycle($user)->create();

        $this->actingAs($user)
            ->post(route('likes.toggle', $item))
            ->assertForbidden();

        $this->assertDatabaseCount('likes', 0);
    }

    public function test_user_can_like_another_users_item(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post(route('likes.toggle', $item))
            ->assertOk();

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
