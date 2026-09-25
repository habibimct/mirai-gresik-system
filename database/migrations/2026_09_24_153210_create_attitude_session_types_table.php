<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attitude_session_types', function (Blueprint $table) {
            $table->id();

            $table->foreignId('attitude_session_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('attitude_type_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(
                ['attitude_session_id', 'attitude_type_id'],
                'attitude_session_type_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attitude_session_types');
    }
};