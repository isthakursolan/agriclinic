<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agent_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_agent_id'); // user with role=field_agent
            $table->unsignedBigInteger('farmer_id');
            $table->unsignedBigInteger('field_id')->nullable();
            $table->unsignedBigInteger('assignment_id')->nullable(); // Added this field
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // // Foreign keys
            // $table->foreign('field_agent_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('farmer_id')->references('id')->on('farmers')->onDelete('cascade');
            // $table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
            // $table->foreign('assignment_id')->references('id')->on('field_agent_assignments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_tasks');
    }
};
