<?php

namespace Tests\Feature\Orders;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\FakeStripeHttpClient;
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

    public function test_user_cannot_create_an_order_by_visiting_the_success_url_directly(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create(['price' => 120]);

        $this->actingAs($user)
            ->get(route('orders.success', $item))
            ->assertForbidden();

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_success_url_is_rejected_when_the_payment_was_not_completed(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create(['price' => 120]);

        $this->actingAs($user)
            ->post(route('orders.checkout', $item), ['payment_method' => 2])
            ->assertRedirect();

        $this->stripe->markUnpaid();

        $this->actingAs($user)
            ->get(route('orders.success', [
                'item'       => $item,
                'session_id' => FakeStripeHttpClient::SESSION_ID,
            ]))
            ->assertForbidden();

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_success_url_is_rejected_for_a_user_who_did_not_pay(): void
    {
        $buyer     = User::factory()->withProfileCompleted()->create();
        $otherUser = User::factory()->withProfileCompleted()->create();
        $item      = Item::factory()->create(['price' => 120]);

        $this->actingAs($buyer)
            ->post(route('orders.checkout', $item), ['payment_method' => 2])
            ->assertRedirect();

        // The checkout session's metadata names $buyer, not $otherUser.
        $this->actingAs($otherUser)
            ->get(route('orders.success', [
                'item'       => $item,
                'session_id' => FakeStripeHttpClient::SESSION_ID,
            ]))
            ->assertForbidden();

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_success_url_cannot_be_replayed_to_create_a_second_order(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create(['price' => 120]);

        $this->actingAs($user)
            ->post(route('orders.checkout', $item), ['payment_method' => 2])
            ->assertRedirect();

        $successUrl = route('orders.success', [
            'item'       => $item,
            'session_id' => FakeStripeHttpClient::SESSION_ID,
        ]);

        $this->actingAs($user)->get($successUrl)->assertRedirect('/');

        // The item is sold now, so the purchase policy denies the replay.
        $this->actingAs($user)->get($successUrl)->assertForbidden();

        $this->assertDatabaseCount('orders', 1);
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
