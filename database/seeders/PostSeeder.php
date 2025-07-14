<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post=Post::factory()->count(50)->create();
        $post->each(
            function ($post) {
                Image::factory()->count(2)->create([
                    'post_id' => $post->id,
                    
                ]);
            }
        );
    }
}
