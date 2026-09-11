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
                ->nullable()
                ->after('id')
                ->constrained('wave_programs')
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('score_types', function (Blueprint $table) {

            $table->dropForeign(['wave_program_id']);
            $table->dropColumn('wave_program_id');

        });
    }
};