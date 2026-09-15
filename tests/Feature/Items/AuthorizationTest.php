<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use App\Models\Order;
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

    public function test_like_button_is_hidden_from_the_seller(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->recycle($user)->create();

        $this->actingAs($user)
            ->get(route('items.show', $item))
            ->assertOk()
            ->assertDontSee('id="like-button"', false);
    }

    public function test_purchase_link_is_hidden_from_the_seller(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->recycle($user)->create();

        $response = $this->actingAs($user)->get(route('items.show', $item));

        $response->assertOk();
        $response->assertDontSee('id="checkout-button"', false);
        $response->assertSee('自分が出品した商品です');
    }

    public function test_purchase_link_is_replaced_by_a_sold_label_for_a_sold_item(): void
    {
        $user  = User::factory()->withProfileCompleted()->create();
        $item  = Item::factory()->create();
        $buyer = User::factory()->withProfileCompleted()->create();

        Order::factory()->recycle([$buyer, $item])->create();

        $response = $this->actingAs($user)->get(route('items.show', $item));

        $response->assertOk();
        $response->assertDontSee('id="checkout-button"', false);
        $response->assertSee('売り切れました');
    }

    public function test_purchase_link_is_shown_to_another_user(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->get(route('items.show', $item))
            ->assertOk()
            ->assertSee('id="checkout-button"', false);
    }

    public function test_purchase_and_like_controls_are_still_shown_to_guests(): void
    {
        $item = Item::factory()->create();

        $response = $this->get(route('items.show', $item));

        $response->assertOk();
        $response->assertSee('id="checkout-button"', false);
        $response->assertSee('id="like-button"', false);
    }
}
