<?php

namespace Tests\Feature\Items;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ItemSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MylistIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_only_shown_items_one_has_liked(): void
    {
        $this->seed([CategorySeeder::class, ItemSeeder::class]);

        $user         = User::factory()->withProfile()->create();
        $likedItem    = Item::inRandomOrder()->first();
        $notLikedItem = Item::whereNot('id', $likedItem->id)->inRandomOrder()->first();

        Like::factory()->recycle([$user, $likedItem])->create();

        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertOk();
        $response->assertViewHas('items', function ($items) use ($likedItem, $notLikedItem) {
            return $items->contains($likedItem) && ! $items->contains($notLikedItem);
        });
    }
}
