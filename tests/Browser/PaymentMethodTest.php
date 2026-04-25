<?php

namespace Tests\Browser;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PaymentMethodTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_payment_method_selection_is_displayed_correctly(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create();

        $this->browse(function (Browser $browser) use ($item, $user) {
            $browser->loginAs($user)
                ->visit('/item/'.$item->id)
                ->press('#checkout-button')
                ->select('#payment-method', '2')
                ->waitForTextIn('#payment-method-display', 'カード支払い')
                ->assertSeeIn('#payment-method-display', 'カード支払い');
        });
    }
}
