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

        Schema::create('sample', function (Blueprint $table) {
            $table->integer('id', true)->unique('id_unique');
            $table->string('sample_id')->unique();
            $table->integer('farmer_id');
            $table->integer('field_id')->nullable();
            $table->integer('crop_id')->nullable();
            $table->string('concern', 255)->nullable();
            $table->integer('sample_type');
            $table->string('collection_method', 255)->nullable();
            $table->string('quantity', 45)->nullable();
            $table->json('package')->nullable();
            $table->json('parameters')->nullable();
            $table->text('amount')->nullable();
            $table->string('sample_status', 45)->default('pending');
            $table->string('verify_payment', 45)->default('0');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->primary(['id']);
              // foreign keys
            $table->foreign('farmer_id')->references('id')->on('profile')->onDelete('cascade');
            $table->foreign('crop_id')->references('id')->on('crop')->onDelete('set null');
            $table->foreign('field_id')->references('id')->on('field')->onDelete('set null');
            $table->foreign('sample_type')->references('id')->on('sample_type')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample');
    }
};
