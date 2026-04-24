<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'              => User::factory(),
            'item_id'              => Item::factory(),
            'payment_method'       => fake()->randomElement(PaymentMethod::class)->value,
            'shipping_postal_code' => fake()->postcode(),
            'shipping_address'     => fake()->address(),
            'shipping_building'    => fake()->optional()->secondaryAddress(),
        ];
    }
}
