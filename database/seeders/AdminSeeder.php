<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Mohanad',
            'username' => 'Mo707',
            'email' => 'mohandahmed015529.222.00@gmail.com',
            'password' => bcrypt('mohandpoh09867'),
            'image' => 'assets/img/admin.png',
            'status' => 1,
            'role_id'=>1,

        ]);
    }
}
