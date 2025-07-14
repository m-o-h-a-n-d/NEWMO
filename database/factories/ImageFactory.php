<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => fake()->randomElement([
                'images/news-350x223-1.jpg',

                'images/news-350x223-3.jpg',
                'images/news-350x223-4.jpg',
                'images/news-350x223-5.jpg',
                'images/news-450x350-1.jpg',
                'images/news-450x350-2.jpg',
                'images/news-825x525.jpg',

            ]),

        ];
    }
}
