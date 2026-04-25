<?php

namespace Tests\Feature\Orders;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_order_item(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create(['price' => 120]);

        $order = Order::factory()->recycle([$user, $item])->create()->toArray();

        $this->actingAs($user)
            ->post(route('orders.checkout', $item), $order)
            ->assertRedirect();

        $this->actingAs($user)
            ->get(route('orders.success', [
                'item'       => $item,
                'session_id' => 'test_session_id',
            ]))
            ->assertRedirect('/');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_bought_item_is_shown_sold(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create(['price' => 120]); // stripe doesn't accept payments less than 120 yen for cards

        $order = Order::factory()->recycle([$user, $item])
            ->create(['payment_method' => 2]) // since webhook isn't implemented, only card payment would be tested here
            ->toArray();

        $this->actingAs($user)
            ->post(route('orders.checkout', $item), $order)
            ->assertRedirect();

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->get(route('orders.success', [
                'item'       => $item,
                'session_id' => 'test_session_id',
            ]));

        $response->assertOk();
        $response->assertViewIs('items.index');
        $response->assertSee('Sold');
    }

    public function test_bought_item_is_shown_in_profile(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create(['price' => 120]); // stripe doesn't accept payments less than 120 yen for cards

        $order = Order::factory()->recycle([$user, $item])
            ->create(['payment_method' => 2]) // since webhook isn't implemented, only card payment would be tested here
            ->toArray();

        $this->actingAs($user)
            ->post(route('orders.checkout', $item), $order)
            ->assertRedirect();

        $this->actingAs($user)
            ->get(route('orders.success', [
                'item'       => $item,
                'session_id' => 'test_session_id',
            ]));

        $response = $this->actingAs($user)
            ->get('/mypage/'.$user->profile->id.'?page=buy');

        $response->assertOk();
        $response->assertSee($item->name);
    }
}
