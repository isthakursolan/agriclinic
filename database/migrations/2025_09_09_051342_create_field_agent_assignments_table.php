<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('field_agent_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_agent_id'); // user with role=field_agent
            $table->unsignedBigInteger('farmer_id')->nullable();
            $table->unsignedBigInteger('field_id')->nullable();
            $table->enum('assignment_type', ['farmer', 'field']);
            $table->enum('status', ['active', 'completed', 'pending'])->default('active');
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamps();

            // Foreign keys
            // $table->foreign('field_agent_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('farmer_id')->references('id')->on('farmers')->onDelete('cascade');
            // $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('field_agent_assignments');
    }
};
