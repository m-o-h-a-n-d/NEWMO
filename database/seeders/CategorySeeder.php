<?php

namespace Database\Seeders;

use App\Models\Category;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str ;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date=fake()->date('Y-m-d H:m:s');
        $categories = ['technology', 'sport',
        'business',  'health'];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'status' => rand(0,1),
                'created_at' => $date,
                'updated_at' => $date,

            ]);
        }
    }
}
