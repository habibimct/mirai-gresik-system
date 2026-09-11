<?php

namespace Database\Seeders;

use App\Models\Participant;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            ScoreTypeSeeder::class,
        ]);

        // Jalankan seeder role terlebih dahulu
        $this->call(RolePermissionSeeder::class);

        // Super Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@mgs.test'],
            [
                'name' => 'Super Admin',
                'phone' => '081234567890',
                'password' => bcrypt('admin123'),
                'is_active' => true,
            ]
        );

        $admin->assignRole('Super Admin');

        // 50 Peserta
        for ($i = 1; $i <= 50; $i++) {

            $user = User::factory()->create();

            $user->assignRole('Peserta');

            Participant::factory()->create([
                'user_id' => $user->id,
            ]);

            $this->command->info("Peserta {$i} berhasil dibuat");
        }
    }
}
