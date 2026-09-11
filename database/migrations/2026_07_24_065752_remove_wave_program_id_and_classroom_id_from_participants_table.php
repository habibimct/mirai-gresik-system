<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {

            // Hapus index terlebih dahulu
            $table->dropIndex('participants_wave_program_id_foreign');
            $table->dropIndex('classroom_id');

            // Baru hapus kolom
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

            $table->index('wave_program_id', 'participants_wave_program_id_foreign');
            $table->index('classroom_id');
        });
    }
};
