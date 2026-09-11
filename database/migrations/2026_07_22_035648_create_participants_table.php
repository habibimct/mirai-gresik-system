<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedBigInteger('program_id')->nullable();

            $table->unsignedBigInteger('wave_id')->nullable();

            $table->unsignedBigInteger('classroom_id')->nullable();

            $table->string('nik', 20)->nullable();

            $table->enum('gender', ['L', 'P'])->nullable();

            $table->string('birth_place')->nullable();

            $table->date('birth_date')->nullable();

            $table->text('address')->nullable();

            $table->string('education')->nullable();

            $table->string('job')->nullable();

            $table->string('status')->default('Aktif');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
