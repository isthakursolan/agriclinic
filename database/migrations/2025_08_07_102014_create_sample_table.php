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
            $table->string('sample_id', 45)->unique('sample_id_unique');
            $table->string('farmer_id', 45)->nullable();
            $table->string('field_id', 45)->nullable();
            $table->string('crop_id', 45)->nullable();
            $table->string('concern', 45)->nullable();
            $table->string('sample_type', 45)->nullable();
            $table->string('collection_method', 45)->nullable();
            $table->string('quantity', 45)->nullable();
            $table->string('package', 45)->nullable();
            $table->string('amount', 45)->nullable();
            $table->string('sample_status', 45)->nullable();
            $table->string('verify_payment', 45)->nullable();
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
        Schema::dropIfExists('sample');
    }
};
