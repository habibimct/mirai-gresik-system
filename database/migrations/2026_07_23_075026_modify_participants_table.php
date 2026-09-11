<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {

            // Tambahkan relasi baru
            $table->foreignId('wave_program_id')
                ->nullable()
                ->after('user_id')
                ->constrained('wave_programs')
                ->nullOnDelete();

            // Hapus relasi lama
            $table->dropColumn([
                'program_id',
                'wave_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {

            $table->unsignedBigInteger('program_id')->nullable();

            $table->unsignedBigInteger('wave_id')->nullable();

            $table->dropForeign(['wave_program_id']);

            $table->dropColumn('wave_program_id');
        });
    }
};