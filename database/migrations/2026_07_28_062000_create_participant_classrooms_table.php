<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participant_classrooms', function (Blueprint $table) {

            $table->id();

            $table->foreignId('participant_wave_program_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('classroom_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('joined_at')->nullable();

            $table->string('status')
                ->default('Aktif');

            $table->timestamps();

            $table->unique(
                ['participant_wave_program_id', 'classroom_id'],
                'participant_classroom_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participant_classrooms');
    }
};
