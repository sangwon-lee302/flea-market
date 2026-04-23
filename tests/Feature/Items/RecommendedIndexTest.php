<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ItemSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendedIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_can_view_all_recommended_items(): void
    {
        $this->seed([CategorySeeder::class, ItemSeeder::class]);

        $items = Item::all();

        $response = $this->get('/');

        $response->assertOk();

        $response->assertViewHas('items', $items);
    }

    public function test_items_bought_by_users_are_shown_as_sold(): void
    {
        $this->seed(CategorySeeder::class);

        $user = User::factory()->create();
        $item = Item::factory()->create();
        $item->categories()->attach(1);

        $response = $this->get('/');
        $response->assertOk();
        $response->assertDontSee('Sold');

        $order = $user->orders()->make([
            'payment_method'       => 1,
            'shipping_postal_code' => '123-4567',
            'shipping_address'     => '東京都千代田区1-1-1',
        ]);
        $order->item()->associate($item);
        $order->save();

        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('Sold');
    }
}
