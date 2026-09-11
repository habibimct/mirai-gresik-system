<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wave_programs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('wave_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('program_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('quota')->default(0);

            $table->decimal('fee',15,2)->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique([
                'wave_id',
                'program_id'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wave_programs');
    }
};