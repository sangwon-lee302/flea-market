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

    public function test_user_is_only_shown_liked_items(): void
    {
        $this->seed([CategorySeeder::class, ItemSeeder::class]);

        $user = User::factory()->withProfileCompleted()->create();

        $likedItems    = Item::whereNot('user_id', $user->id)->inRandomOrder()->limit(rand(1, 3))->get();
        $notLikedItems = Item::whereNotIn('id', $likedItems->pluck('id'))->inRandomOrder()->get();

        Like::factory()->recycle($user)->recycle($likedItems)->create();

        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertOk();
        $response->assertViewHas('items', function ($items) use ($likedItems, $notLikedItems) {
            $allLikedPresent     = $items->diff($likedItems)->isEmpty();
            $noneNotLikedPresent = $items->intersect($notLikedItems)->isEmpty();

            return $allLikedPresent && $noneNotLikedPresent;
        });
    }
}
