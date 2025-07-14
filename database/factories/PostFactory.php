<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date=fake()->date('Y-m-d H:m:s');
        return [
            'title'=>fake()->sentence(3),
            // slugable is the library in laravel it put in moodel
            'description'=>fake()->paragraph(5),
            'comment_able'=>fake()->randomElement([0,1]),
            'status'=>fake()->randomElement([0,1]),
            'user_id'=>User::inRandomOrder()->first()->id,
            'admin_id'=>Admin::inRandomOrder()->first()->id,
            'category_id'=> Category::inRandomOrder()->first()->id,
            'created_at'=>$date,
            'updated_at'=>$date,

        ];
    }
}
