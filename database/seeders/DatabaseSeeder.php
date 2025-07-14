<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            ContactSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            RelatedSitesSeeder::class,
            NumberOfViewSeeder::class,





        ]);
    }
}
