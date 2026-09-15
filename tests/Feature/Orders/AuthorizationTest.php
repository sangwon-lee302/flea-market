<?php

namespace Tests\Feature\Orders;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_cannot_open_purchase_page_for_their_own_item(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->recycle($user)->create();

        $this->actingAs($user)
            ->get(route('orders.create', $item))
            ->assertForbidden();
    }

    public function test_seller_cannot_checkout_their_own_item(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->recycle($user)->create();

        $this->actingAs($user)
            ->post(route('orders.checkout', $item), ['payment_method' => 2])
            ->assertForbidden();

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_user_cannot_purchase_an_already_sold_item(): void
    {
        $user  = User::factory()->withProfileCompleted()->create();
        $item  = Item::factory()->create(['price' => 120]);
        $buyer = User::factory()->withProfileCompleted()->create();

        Order::factory()->recycle([$buyer, $item])->create();

        $this->actingAs($user)
            ->get(route('orders.create', $item))
            ->assertForbidden();

        $this->actingAs($user)
            ->post(route('orders.checkout', $item), ['payment_method' => 2])
            ->assertForbidden();
    }

    public function test_shipping_address_routes_are_denied_for_the_sellers_own_item(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->recycle($user)->create();

        $this->actingAs($user)
            ->post(route('shipping_addresses.edit', $item))
            ->assertForbidden();

        $this->actingAs($user)
            ->post(route('shipping_addresses.update', $item), [
                'postal_code' => '123-4567',
                'address'     => '東京都渋谷区1-2-3',
            ])
            ->assertForbidden();
    }

    public function test_shipping_address_routes_are_denied_for_a_sold_item(): void
    {
        $user  = User::factory()->withProfileCompleted()->create();
        $item  = Item::factory()->create();
        $buyer = User::factory()->withProfileCompleted()->create();

        Order::factory()->recycle([$buyer, $item])->create();

        $this->actingAs($user)
            ->post(route('shipping_addresses.edit', $item))
            ->assertForbidden();
    }
}
