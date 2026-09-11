<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participant_wave_programs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('participant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('wave_program_id')
                ->constrained()
                ->cascadeOnDelete();

            // biaya yang disepakati untuk peserta
            $table->decimal('agreed_fee', 15, 2)
                ->nullable();

            // potongan biaya
            $table->decimal('discount', 15, 2)
                ->default(0);

            $table->string('status')
                ->default('Aktif');

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'participant_id',
                'wave_program_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participant_wave_programs');
    }
};