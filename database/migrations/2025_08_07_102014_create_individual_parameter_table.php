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
        Schema::create('individual_parameter', function (Blueprint $table) {
            $table->integer('id', true)->unique('id_unique');
            $table->string('parameter', 100);
            $table->string('symbol', 45);
            $table->string('reporting_time', 45)->nullable();
            $table->integer('price');
            $table->integer('sample_type');
            $table->string('reading_type', 45)->nullable();
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
        Schema::dropIfExists('individual_parameter');
    }
};
