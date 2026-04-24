<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use App\Models\Like;
use App\Models\Order;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ItemSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MylistIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_only_shown_liked_items(): void
    {
        $this->seed([CategorySeeder::class, ItemSeeder::class]);

        $user = User::factory()->withProfileCompleted()->create();

        $likedItem    = Item::whereNot('user_id', $user->id)->first();
        $notLikedItem = Item::whereNotIn('id', [$likedItem->id])->first();

        Like::factory()->recycle([$user, $likedItem])->create();

        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertOk();
        $response->assertViewHas('items', function ($items) use ($likedItem, $notLikedItem) {
            return $items->contains($likedItem) && ! $items->contains($notLikedItem);
        });
    }

    public function test_sold_item_is_shown_sold(): void
    {
        $this->seed([CategorySeeder::class, ItemSeeder::class]);

        $user = User::factory()->withProfileCompleted()->create();

        $likedItem = Item::whereNot('user_id', $user->id)->first();

        Like::factory()->recycle([$user, $likedItem])->create();

        $otherUser = User::factory()->withProfileCompleted()->create();

        Order::factory()->recycle([$otherUser, $likedItem])->create();

        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertOk();
        $response->assertSee('Sold');
    }
}
