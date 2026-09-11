<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('score_session_types', function (Blueprint $table) {

            $table->id();

            $table->foreignId('score_session_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('score_type_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(
                ['score_session_id','score_type_id'],
                'score_session_type_unique'
            );

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('score_session_types');
    }
};