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
        Schema::create('participant_invoices', function (Blueprint $table) {

            $table->id();

            $table->foreignId('participant_classroom_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('total_amount', 12, 2)->default(0);

            $table->decimal('paid_amount', 12, 2)->default(0);

            $table->enum('status', [
                'Belum Bayar',
                'Sebagian',
                'Lunas'
            ])->default('Belum Bayar');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_invoices');
    }
};
