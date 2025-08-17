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
        Schema::create('crop', function (Blueprint $table) {
            $table->integer('id', true)->unique('id_unique');
            $table->string('cat', 45)->nullable();
            $table->string('type', 45)->nullable();
            $table->string('crop', 100)->nullable();
            $table->string('rootstock', 10)->nullable();
            $table->string('variety', 10)->nullable();
            $table->string('aging', 45)->nullable();
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
        Schema::dropIfExists('crop');
    }
};
