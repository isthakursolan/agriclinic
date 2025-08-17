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
        Schema::create('payments', function (Blueprint $table) {
            $table->integer('id', true)->unique('id_unique');
            $table->date('date');
            $table->decimal('amount', 2, 0)->nullable();
            $table->string('sample_id', 45)->nullable();
            $table->string('transaction_id', 45)->nullable();
            $table->string('confirm_payment', 45)->nullable();
            $table->string('mode', 45)->nullable();
            $table->string('status', 45)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
