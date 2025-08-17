<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTable extends Migration
{
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->integer('id', true)->unique('id_unique');
            $table->string('fullname', 100);
            $table->string('username', 45)->nullable()->default('NULL');
            $table->string('gender', 45)->nullable()->default('NULL');
            $table->string('id_type', 45)->nullable()->default('NULL');
            $table->string('id_no', 45)->nullable()->default('NULL');
            $table->integer('contact',);
            $table->integer('whatsapp',)->nullable()->default('NULL');
            $table->string('email', 100);
            $table->string('qualification', 45)->nullable()->default('NULL');
            $table->string('address', 100)->nullable()->default('NULL');
            $table->string('postoffice', 100)->nullable()->default('NULL');
            $table->string('district', 100)->nullable()->default('NULL');
            $table->string('state', 100)->nullable()->default('NULL');
            $table->string('pincode', 45)->nullable()->default('NULL');
            $table->string('referred_by', 45)->nullable()->default('NULL');
            $table->string('crop_grown', 45)->nullable()->default('NULL');
            $table->string('land_area_cultivated', 45)->nullable()->default('NULL');
            $table->string('land_area_total', 45)->nullable()->default('NULL');
            $table->string('farming_since', 45)->nullable()->default('NULL');
            $table->text('technology_intervention');
            $table->string('capital_investment', 45)->nullable()->default('NULL');
            $table->text('future_plans');
            $table->text('info_on_all_crops');
            $table->datetime('created_at')->nullable()->default('NULL');
            $table->datetime('updated_at')->nullable()->default('NULL');
            $table->primary('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile');
    }
}
