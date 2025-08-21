<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveCropTable extends Migration
{
    public function up()
    {
        Schema::create('active_crop', function (Blueprint $table) {

		$table->integer('id', true)->unique('id_unique');
		$table->string('name',45);
		$table->string('farmer_id',45);
		$table->string('plot_id',45);
		$table->string('crop_cat',45);
		$table->string('variety',45)->nullable();
		$table->string('rootstock',45)->nullable() ;
		$table->date('sowing_date')->nullable() ;
		$table->date('expected_harvest_date')->nullable() ;
		$table->text('fertilizer_plan');
		$table->text('photo');
		$table->text('description');
		$table->datetime('created_at')->nullable() ;
		$table->datetime('updated_at')->nullable() ;
		$table->primary('id');
        $table->foreign('farmer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('active_crop');
    }
}
