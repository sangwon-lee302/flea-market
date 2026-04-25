<?php

namespace Database\Factories;

use App\Condition;
use App\Models\Category;
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
            'image'       => 'images/default-item-image.jpg',
            'condition'   => fake()->randomElement(Condition::class)->value,
            'name'        => fake()->words(3, true),
            'brand_name'  => fake()->company(),
            'description' => fake()->realText(255),
            'price'       => fake()->numberBetween(1),
        ];
    }

    /**
     * Configure the model's factory to attach the item to some random categories.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Item $item) {
            if ($item->categories()->exists()) {
                return;
            }

            $item->categories()->attach(
                Category::inRandomOrder()->limit(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
