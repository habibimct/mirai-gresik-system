<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attitude_types', function (Blueprint $table) {

            $table->id();

            $table->foreignId('wave_program_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->unique(
                ['wave_program_id', 'name'],
                'attitude_type_wave_program_name_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attitude_types');
    }
};