<?php

namespace Database\Seeders;

use App\Models\Autharization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [];
        foreach (config('autharization.permission') as $permission => $value) {
            $permissions[] = $permission;
        }
        Autharization::create([
            'role' => 'admin',
            'permissions' =>
            $permissions

        ]);
    }
}
