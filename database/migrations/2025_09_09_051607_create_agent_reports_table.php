<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agent_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('field_agent_id'); // user with role=field_agent
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable(); // store image/file paths
            $table->timestamp('submitted_at')->useCurrent();
            $table->enum('status', ['pending_review', 'approved', 'rejected'])->default('pending_review');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            // Foreign keys
            // $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            // $table->foreign('field_agent_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_reports');
    }
};
