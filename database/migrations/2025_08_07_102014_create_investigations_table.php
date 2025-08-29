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
        Schema::create('investigations', function (Blueprint $table) {
            $table->integer('id', true)->unique('id_unique');
            $table->integer('sample_id');
            $table->integer('parameter')->nullable();
            $table->string('reading1', 45)->nullable();
            $table->string('reading2', 45)->nullable();
            $table->string('dilusion', 45)->nullable();
            $table->string('verify_entry', 45)->nullable();
            $table->string('result')->nullable();
            $table->text('interpretation')->nullable();
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
        Schema::dropIfExists('investigations');
    }
};
