<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            $table->dropForeign(['wave_program_id']);

            // Hapus kolom yang sudah tidak digunakan
            $table->dropColumn([
                'wave_program_id',
                'classroom_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->unsignedBigInteger('wave_program_id')->nullable();
            $table->unsignedBigInteger('classroom_id')->nullable();

            $table->index('classroom_id');

            $table->foreign('wave_program_id')
                ->references('id')
                ->on('wave_programs')
                ->nullOnDelete();
        });
    }
};