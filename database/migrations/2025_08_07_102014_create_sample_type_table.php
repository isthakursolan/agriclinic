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
        Schema::create('sample_type', function (Blueprint $table) {
            $table->integer('id', true)->unique('id_unique');
            $table->string('e_type', 45)->nullable();
            $table->string('h_type', 45)->nullable();
            $table->string('sample_size', 45)->nullable();
            $table->string('buffer_size', 45)->nullable();
            $table->string('batch_prefix', 45)->nullable()->unique('batch_prefix_unique');
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
        Schema::dropIfExists('sample_type');
    }
};
