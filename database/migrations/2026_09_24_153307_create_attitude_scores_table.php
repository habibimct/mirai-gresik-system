<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attitude_scores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('attitude_session_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('participant_classroom_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('attitude_type_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('score', 5, 2);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(
                [
                    'attitude_session_id',
                    'participant_classroom_id',
                    'attitude_type_id'
                ],
                'attitude_score_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attitude_scores');
    }
};