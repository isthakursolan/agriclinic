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
            $table->integer('user_id');
            $table->string('fullname', 100);
            $table->string('username', 45)->nullable() ;
            $table->string('gender', 45)->nullable() ;
            $table->string('id_type', 45)->nullable() ;
            $table->string('id_no', 45)->nullable() ;
            $table->bigInteger('contact');
            $table->bigInteger('whatsapp')->nullable();
            $table->string('email', 100);
            $table->string('qualification', 45)->nullable();
            $table->string('address', 100)->nullable() ;
            $table->string('postoffice', 100)->nullable() ;
            $table->string('district', 100)->nullable() ;
            $table->string('state', 100)->nullable() ;
            $table->string('pincode', 45)->nullable() ;
            $table->string('referred_by', 45)->nullable() ;
            $table->string('crop_grown', 45)->nullable() ;
            $table->string('land_area_cultivated', 45)->nullable() ;
            $table->string('land_area_total', 45)->nullable() ;
            $table->string('farming_since', 45)->nullable() ;
            $table->text('technology_intervention')->nullable();
            $table->string('capital_investment', 45)->nullable() ;
            $table->text('future_plans')->nullable();
            $table->text('info_on_all_crops')->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->primary('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('profile');
    }
}
