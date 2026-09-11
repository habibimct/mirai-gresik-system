<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('score_types', function (Blueprint $table) {
            $table->unique(
                ['wave_program_id', 'name'],
                'score_types_wave_program_id_name_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('score_types', function (Blueprint $table) {
            $table->dropUnique('score_types_wave_program_id_name_unique');
        });
    }
};