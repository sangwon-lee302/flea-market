<?php

namespace Tests\Feature\Profiles;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_is_shown_correctly(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->recycle($user)->create();

        $boughtItem = Item::factory()->recycle($user)->create();
        Order::factory()->recycle([$user, $boughtItem])->create();

        $response = $this->actingAs($user)
            ->get('/mypage/'.$user->profile->id);

        $response->assertOk();
        $response->assertViewIs('profiles.show');
        $response->assertSee(asset('storage/'.$user->profile->avatar));
        $response->assertSee($user->profile->name);
        $response->assertSee(asset('storage/'.$item->image));
        $response->assertSee($item->name);

        $response = $this->actingAs($user)
            ->get('/mypage/'.$user->profile->id.'?page=buy');

        $response->assertOk();
        $response->assertViewIs('profiles.show');
        $response->assertSee(asset('storage/'.$user->profile->avatar));
        $response->assertSee($user->profile->name);
        $response->assertSee(asset('storage/'.$boughtItem->image));
        $response->assertSee($boughtItem->name);
    }

    public function test_default_profile_information_is_shown(): void
    {
        $nickname   = 'nickname1';
        $postalCode = '100-0000';
        $address    = 'Tokyo 1-1-1';
        $building   = 'Building A';

        $user = User::factory()->withProfileCompleted($nickname, $postalCode, $address, $building)->create();

        $response = $this->actingAs($user)
            ->get('/mypage/profile/'.$user->profile->id);

        $response->assertOk();
        $response->assertViewIs('profiles.edit');
        $response->assertSee(asset('storage/'.$user->profile->avatar));
        $response->assertSee($nickname);
        $response->assertSee($postalCode);
        $response->assertSee($address);
        $response->assertSee($building);
    }
}
