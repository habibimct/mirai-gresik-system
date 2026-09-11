<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('score_types', function (Blueprint $table) {
            $table->foreignId('wave_program_id')
                ->nullable(false)
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('score_types', function (Blueprint $table) {
            $table->foreignId('wave_program_id')
                ->nullable()
                ->change();
        });
    }
};