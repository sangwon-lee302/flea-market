<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_partial_match_search_by_item_name_is_working(): void
    {
        $searchItem = Item::factory()->create(['name' => 'Search Item Name']);
        $otherItem  = Item::factory()->create(['name' => 'Other Item Name']);

        $searchKeyword = 'Search';

        $response = $this->get('/?keyword='.urlencode($searchKeyword));

        $response->assertOk();
        $response->assertSee($searchItem->name);
        $response->assertDontSee($otherItem->name);
    }

    public function test_search_keyword_is_kept_in_mylist(): void
    {
        $searchKeyword = 'Search';

        $response = $this->get('/?keyword='.urlencode($searchKeyword));

        $response->assertOk();

        // check if the mylist link in the navigation contains the search keyword
        $response->assertSeeInOrder(['おすすめ', 'keyword='.urlencode($searchKeyword)]);
        $response->assertSeeInOrder(['keyword='.urlencode($searchKeyword), 'マイリスト']);
    }
}
