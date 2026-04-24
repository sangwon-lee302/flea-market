<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_partial_match_search_by_item_name_is_possible(): void
    {
        $searchItem = Item::factory()->create(['name' => 'Test Item Name']);
        $otherItem  = Item::factory()->create(['name' => 'Other Item Name']);

        $searchKeyword = 'Test';
        $response      = $this->get('/?keyword='.urlencode($searchKeyword));

        $response->assertOk();

        $response->assertViewHas('items', function ($items) use ($searchItem, $otherItem) {
            return $items->contains($searchItem) && ! $items->contains($otherItem);
        });
    }

    public function test_search_keyword_is_kept_in_mylist(): void
    {
        $searchItem = Item::factory()->create(['name' => 'Test Item Name']);
        $otherItem  = Item::factory()->create(['name' => 'Other Item Name']);

        $searchKeyword = 'Test';

        $response = $this->get('/?keyword='.urlencode($searchKeyword));

        $response->assertOk();
        $response->assertViewHas('items', function ($items) use ($searchItem, $otherItem) {
            return $items->contains($searchItem) && ! $items->contains($otherItem);
        });

        $user = User::factory()->withProfileCompleted()->create();

        Like::factory()->recycle([$user, $searchItem])->create();
        Like::factory()->recycle([$user, $otherItem])->create();

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword='.urlencode($searchKeyword));

        $response->assertOk();
        $response->assertViewHas('items', function ($items) use ($searchItem, $otherItem) {
            return $items->contains($searchItem) && ! $items->contains($otherItem);
        });
    }
}
