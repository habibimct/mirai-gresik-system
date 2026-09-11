<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waves', function (Blueprint $table) {

            $table->id();

            $table->string('code',20)->unique();

            $table->string('name');

            $table->year('year');

            $table->date('registration_start')->nullable();

            $table->date('registration_end')->nullable();

            $table->date('training_start')->nullable();

            $table->date('training_end')->nullable();

            $table->boolean('is_active')->default(true);

            $table->text('description')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waves');
    }
};
