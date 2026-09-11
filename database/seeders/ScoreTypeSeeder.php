<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ScoreType;

class ScoreTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Bunpou',
            'Chokai',
            'Kaiwa',
            'Kanji',
        ];

        foreach ($types as $type) {

            ScoreType::updateOrCreate(
                ['name' => $type],
                ['is_active' => true]
            );

        }
    }
}