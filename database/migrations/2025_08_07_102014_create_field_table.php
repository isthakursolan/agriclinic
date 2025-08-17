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
        Schema::create('field', function (Blueprint $table) {
            $table->integer('id', true)->unique('id_unique');
            $table->integer('farmer_id')->nullable();
            $table->string('field_name', 255)->nullable();
            $table->decimal('field_area', 10)->nullable();
            $table->string('land_profile', 255)->nullable();
            $table->string('road_connectivity', 40  )->nullable();
            $table->string('type_of_field', 255)->nullable();
            $table->string('irrigation_system', 40)->nullable();
            $table->string('source_of_irrigation', 255)->nullable();
            $table->string('soil_type', 50)->nullable();
            $table->string('field_latitude', 255)->nullable();
            $table->string('field_longitude', 255)->nullable();
            $table->text('field_boundary')->nullable();
            $table->text('description')->nullable();
            $table->string('map_image', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field');
    }
};
