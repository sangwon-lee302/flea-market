<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ItemSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendedIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CategorySeeder::class);
    }

    public function test_unauthenticated_user_can_view_all_recommended_items(): void
    {
        $this->seed(ItemSeeder::class);

        $items = Item::all();

        $response = $this->get('/');

        $response->assertOk();

        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    public function test_only_items_bought_by_users_are_shown_as_sold(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Order::factory()->recycle([$user, $item])->create();

        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('Sold');
    }

    public function test_authenticated_user_is_not_shown_items_one_has_listed(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->recycle($user)->create();

        $response = $this->actingAs($user)->get('/');
        $response->assertOk();
        $response->assertDontSee($item->name);
    }
}
