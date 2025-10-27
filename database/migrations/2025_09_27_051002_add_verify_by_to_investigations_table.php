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
        Schema::table('investigations', function (Blueprint $table) {
            $table->integer('verify_by')->nullable(true)->after('verify_entry');
        });
    }

    public function down()
    {
        Schema::table('investigations', function (Blueprint $table) {
            $table->dropColumn('verify_by');
        });
    }
};
