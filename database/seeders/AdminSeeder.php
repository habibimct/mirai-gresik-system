<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@mgs.test'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('admin123'),
            ]
        );

        $user->assignRole('Super Admin');
    }
}