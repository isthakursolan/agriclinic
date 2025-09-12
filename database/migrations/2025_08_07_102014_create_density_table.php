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
        Schema::create('density', function (Blueprint $table) {
            $table->integer('id', true)->unique('id_unique');
            $table->string('crop', 45)->nullable();
            $table->string('e_density', 45)->nullable();
            $table->string('h_density', 45)->nullable();
            $table->string('row_to_row', 45)->nullable();
            $table->string('plant_to_plant', 45)->nullable();
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
        Schema::dropIfExists('density');
    }
};
