<?php

namespace Tests\Feature\Orders;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShippingAddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_shipping_address_can_be_changed(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->get('/purchase/'.$item->id)
            ->assertOk();

        $this->actingAs($user)
            ->post('/purchase/address/'.$item->id)
            ->assertOk();

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->post('/purchase/address/'.$item->id.'/update', [
                'postal_code' => '123-4567',
                'address'     => '東京都渋谷区1-2-3',
                'building'    => '渋谷ビル101',
            ]);

        $response->assertOk();
        $response->assertViewIs('orders.create');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区1-2-3');
        $response->assertSee('渋谷ビル101');
    }

    public function test_shipping_address_is_stored_correctly(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create(['price' => 120]); // stripe doesn't accept payments less than 120 yen for cards

        $this->actingAs($user)
            ->get('/purchase/'.$item->id)
            ->assertOk();

        $this->actingAs($user)
            ->post('/purchase/address/'.$item->id)
            ->assertOk();

        $postal_code = '123-4567';
        $address     = '東京都渋谷区1-2-3';
        $building    = '渋谷ビル101';

        $this->actingAs($user)
            ->followingRedirects()
            ->post(route('shipping_addresses.update', $item), [
                'postal_code' => $postal_code,
                'address'     => $address,
                'building'    => $building,
            ])
            ->assertOk()
            ->assertViewIs('orders.create');

        $order = Order::factory()->recycle([$user, $item])
            ->create(['payment_method' => 2]) // since webhook isn't implemented, only card payment would be tested here
            ->toArray();

        $this->actingAs($user)
            ->post(route('orders.checkout', $item), $order)
            ->assertRedirect();

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
            'user_id'              => $user->id,
            'item_id'              => $item->id,
            'shipping_postal_code' => $postal_code,
            'shipping_address'     => $address,
            'shipping_building'    => $building,
        ]);
    }
}
