<?php

namespace Tests\Browser;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LikeTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_likes_count_updated_after_liking(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->recycle($user)->create();

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit('/item/'.$item->id)
                ->assertSeeIn('#like-count', '0')
                ->press('#like-button')
                ->waitForTextIn('#like-count', '1')
                ->assertSeeIn('#like-count', '1');
        });

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_likes_icon_updated_after_liking(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->recycle($user)->create();

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit('/item/'.$item->id)
                ->assertAttribute('#like-icon', 'src', asset('images/likes_off.png'))
                ->press('#like-button')
                ->waitFor('#like-icon')
                ->assertAttribute('#like-icon', 'src', asset('images/likes_on.png'));
        });
    }
}
