<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Processors\Processor;
use Illuminate\Database\Query\Builder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sample', function (Blueprint $table) {
            // Field agent collection tracking
            $table->string('collected_by_agent')->nullable(); // Agent name/ID who collected it
            $table->timestamp('collected_at')->nullable(); // Collection timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sample', function (Blueprint $table) {
            $table->dropColumn(['collected_by_agent', 'collected_at']);
        });
    }
};
