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
        Schema::create('package_parameters', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id');
            $table->integer('parameter_id');
            $table->timestamps();
             // Foreign keys
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('parameter_id')->references('id')->on('individual_parameter')->onDelete('cascade');

            // Avoid duplicates
            $table->unique(['package_id', 'parameter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_parameters');
    }
};
