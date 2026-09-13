<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use App\Models\User;
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

    public function test_header_search_form_does_not_leak_page_param_from_profile_page(): void
    {
        $user = User::factory()->withProfileCompleted()->create();

        $response = $this->actingAs($user)->get('/mypage/'.$user->profile->id.'?page=sell');

        $response->assertOk();
        $response->assertDontSee('name="page"', false);
    }

    public function test_header_search_form_keeps_tab_param(): void
    {
        $response = $this->get('/?tab=mylist');

        $response->assertOk();
        $response->assertSeeInOrder(['name="tab"', 'value="mylist"']);
    }

    public function test_recommended_tab_is_highlighted_by_default(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSeeInOrder(['text-red-500', 'おすすめ']);
        // only one nav link should be highlighted at a time
        $this->assertSame(1, substr_count($response->getContent(), 'text-red-500'));
    }

    public function test_mylist_tab_is_highlighted_when_active(): void
    {
        $response = $this->get('/?tab=mylist');

        $response->assertOk();
        $response->assertSeeInOrder(['text-red-500', 'マイリスト']);
        // only one nav link should be highlighted at a time
        $this->assertSame(1, substr_count($response->getContent(), 'text-red-500'));
    }

    public function test_recommended_link_drops_tab_param_while_on_mylist(): void
    {
        $response = $this->get('/?tab=mylist');

        $response->assertOk();
        // the "おすすめ" link's href must not carry over tab=mylist
        $response->assertSeeInOrder(['href="'.route('items.index').'"', 'おすすめ']);
    }
}
