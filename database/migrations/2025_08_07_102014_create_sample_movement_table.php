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
        Schema::create('sample_movement', function (Blueprint $table) {
            $table->integer('id', true)->unique('id_unique');
            $table->string('sample_id', 45);
            $table->dateTime('timestamp');
            $table->string('user_id', 45)->nullable();
            $table->string('action', 45)->nullable();
            $table->string('target', 45)->nullable();
            $table->string('method', 45)->nullable();
            $table->string('mode', 45)->nullable();
            $table->string('picture', 45)->nullable();
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
        Schema::dropIfExists('sample_movement');
    }
};
