<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backups', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | User yang membuat backup
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Informasi Backup
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('filename');

            $table->string('disk')
                ->default('local');

            $table->unsignedBigInteger('size')
                ->default(0);


            /*
            |--------------------------------------------------------------------------
            | Isi Backup
            |--------------------------------------------------------------------------
            |
            | database
            | files
            | full
            |
            */

            $table->string('type')
                ->default('full');


            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            |
            | pending
            | processing
            | completed
            | failed
            |
            */

            $table->string('status')
                ->default('pending');


            /*
            |--------------------------------------------------------------------------
            | Informasi tambahan
            |--------------------------------------------------------------------------
            */

            $table->text('description')
                ->nullable();

            $table->text('error_message')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Waktu
            |--------------------------------------------------------------------------
            */

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('backups');
    }
};