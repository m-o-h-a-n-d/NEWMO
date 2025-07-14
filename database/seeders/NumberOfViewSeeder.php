<?php

namespace Database\Seeders;

use App\Models\NumberOfView;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NumberOfViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تأكد الأول إن فيه users و posts متسجلين
        if (User::count() == 0 || Post::count() == 0) {
            $this->command->info('Users or Posts not found, seeding skipped.');
            return;
        }

        // كل مستخدم هيشوف 5 بوستات عشوائيًا مثلاً
        $users = User::all();
        foreach ($users as $user) {
            $posts = Post::inRandomOrder()->take(5)->get();

            foreach ($posts as $post) {
                NumberOfView::firstOrCreate([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                ], [
                    'ip_address' => fake()->ipv4,
                ]);
            }
        }
    }
}
