<?php

namespace Tests\Feature\Items;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_item(): void
    {
        $this->seed(CategorySeeder::class);

        Storage::fake('public');

        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->recycle($user)->make([
            'categories' => Category::limit(3)->pluck('name')->toArray(),
        ])
            ->toArray();
        $item['image'] = UploadedFile::fake()->image('item.jpg');

        $this->actingAs($user)
            ->get('/sell')
            ->assertOk();

        $this->actingAs($user)
            ->post(route('items.store'), $item)
            ->assertRedirect('/mypage/'.$user->profile->id);

        $this->assertDatabaseHas('items', [
            'user_id'     => $user->id,
            'image'       => 'images/'.$item['image']->hashName(),
            'condition'   => $item['condition'],
            'name'        => $item['name'],
            'brand_name'  => $item['brand_name'],
            'description' => $item['description'],
            'price'       => $item['price'],
        ]);

        foreach ($item['categories'] as $categoryName) {
            $this->assertDatabaseHas('category_item', [
                'item_id'     => Item::firstWhere('name', $item['name'])->id,
                'category_id' => Category::firstWhere('name', $categoryName)->id,
            ]);
        }

        Storage::disk('public')->assertExists('images/'.$item['image']->hashName());
    }
}
