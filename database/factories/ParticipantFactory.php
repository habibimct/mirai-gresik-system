<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nik' => fake()->unique()->numerify('################'),

            'gender' => fake()->randomElement(['L', 'P']),

            'birth_place' => fake()->city(),

            'birth_date' => fake()->dateTimeBetween('-30 years', '-17 years'),

            'address' => fake()->address(),

            'education' => fake()->randomElement([
                'SMA',
                'SMK',
                'D3',
                'S1',
            ]),

            'job' => fake()->randomElement([
                'Belum Bekerja',
                'Karyawan',
                'Freelancer',
                'Pelajar',
            ]),

            'status' => fake()->randomElement([
                'Aktif',
                'Lulus',
                'Keluar',
            ]),
        ];
    }
}
