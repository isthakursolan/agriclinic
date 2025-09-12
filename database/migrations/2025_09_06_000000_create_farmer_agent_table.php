<?php
// database/migrations/2025_09_06_000000_create_farmer_agent_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('farmer_agent', function (Blueprint $table) {
            $table->id();
            $table->integer('farmer_id');
            $table->integer('agent_id');
            // $table->foreignId('farmer_id')->constrained('profile')->onDelete('cascade');
            // $table->foreignId('agent_id')->constrained('profile')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['farmer_id', 'agent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farmer_agent');
    }
};
