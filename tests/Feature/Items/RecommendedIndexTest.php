<?php

namespace Tests\Feature\Items;

use App\Models\Item;
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
        $itemNames = Item::all()->pluck('name')->toArray();

        $response = $this->get('/');

        $response->assertOk();

        foreach ($itemNames as $itemName) {
            $response->assertSee($itemName);
        }
    }
}
