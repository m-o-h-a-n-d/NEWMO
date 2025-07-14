<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment'=>fake()->text(30),
            'status'=>fake()->randomElement([0, 1]),
            'ip_address'=>fake()->ipv4(),

            'user_id'=>User::inRandomOrder()->first()->id, // fake user id
            'post_id'=> Post::inRandomOrder()->first()->id, // fake post id

        ];
    }
}
