<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->name(),
            'phone' => fake()->unique()->phoneNumber(),

            'country' => fake()->country(),
            'city' => fake()->city(),
            'street' => fake()->streetAddress(),
            'status' => fake()->randomElement([0, 1]),
            'image'=>fake()->randomElement([
                    'images/news-350x223-1.jpg',
                    'images/news-350x223-2.jpg',
                    'images/news-350x223-3.jpg',
                    'images/news-350x223-4.jpg',
                    'images/news-350x223-5.jpg',
                    'images/news-450x350-1.jpg',
                    'images/news-450x350-2.jpg',
                    'images/news-825x525.jpg',

                ]),

            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }


    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
