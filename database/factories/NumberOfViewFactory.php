<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\NumberOfView;

class NumberOfViewFactory extends Factory
{
    protected $model = NumberOfView::class; // ✅ ربط الموديل

    public function definition(): array
    {
        return [
            'post_id' => Post::inRandomOrder()->first()?->id ?? 1,
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'ip_address' => $this->faker->ipv4,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
