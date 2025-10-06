<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sample_buffer', function (Blueprint $table) {
            $table->integer('accept_by')->nullable(false)->after('sample_id');
        });
    }

    public function down()
    {
        Schema::table('sample_buffer', function (Blueprint $table) {
            $table->dropColumn('accept_by');
        });
    }
};
