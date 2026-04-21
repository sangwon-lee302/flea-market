<?php

namespace Database\Factories;

use App\Condition;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'image_path'  => 'items/default.jpg',
            'condition'   => fake()->randomElement(Condition::class)->value,
            'name'        => fake()->word(),
            'brand_name'  => fake()->company(),
            'description' => fake()->realText(255),
            'price'       => fake()->numberBetween(1),
        ];
    }
}
