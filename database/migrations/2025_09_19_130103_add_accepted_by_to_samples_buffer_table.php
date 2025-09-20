<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sample_buffer', function (Blueprint $table) {
            $table->unsignedBigInteger('accept_by')->nullable(); // User who accepted the sample
            $table->foreign('accept_by')->references('id')->on('users')->onUpdate('set null');
        });
    }

    public function down()
    {
        Schema::table('sample_buffer', function (Blueprint $table) {
            $table->dropForeign(['accept_by']);
            $table->dropColumn('accept_by');
        });
    }
};
