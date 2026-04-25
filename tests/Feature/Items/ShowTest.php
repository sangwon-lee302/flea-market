<?php

namespace Tests\Feature\Items;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_all_necessary_information(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Comment::factory()->recycle([$user, $item])->create();

        $response = $this->get(route('items.show', $item));

        $response->assertOk();
        $response->assertSee(asset('storage/'.$item->image), false);
        $response->assertSee($item->name);
        $response->assertSee($item->brand_name);
        $response->assertSee(number_format($item->price));
        $response->assertSee($item->likes_count);
        $response->assertSee($item->comments_count);
        $response->assertSee($item->description);
        $response->assertSee('カテゴリー');
        $response->assertSee($item->condition);
        foreach ($item->comments as $comment) {
            $response->assertSee($comment->user->profile->nickname);
            $response->assertSee($comment->body);
        }
    }

    public function test_it_shows_all_categories_of_an_item(): void
    {
        $item = Item::factory()->create();

        $categories = $item->categories;

        $response = $this->get(route('items.show', $item));

        $response->assertOk();
        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }
}
