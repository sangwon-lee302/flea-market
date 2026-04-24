<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
        ];
    }

    /**
     * Configure the model factory to automatically create a corresponding profile.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->profile()->create();
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model's corresponding profile should have a nickname, postal code, and address.
     */
    public function withProfileCompleted(?string $nickname = null, ?string $postalCode = null, ?string $address = null): static
    {
        return $this->afterCreating(function (User $user) use ($nickname, $postalCode, $address) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nickname'    => $nickname ?? fake()->userName(),
                    'postal_code' => $postalCode ?? fake()->postcode(),
                    'address'     => $address ?? fake()->address(),
                ]
            );
        });
    }
}
