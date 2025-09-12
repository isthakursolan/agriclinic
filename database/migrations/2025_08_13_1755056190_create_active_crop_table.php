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
		$table->integer('farmer_id');
		$table->string('plot_id',45);
		$table->string('crop_cat',45);
		$table->string('variety',45)->nullable();
		$table->string('rootstock',45)->nullable() ;
		$table->date('sowing_date')->nullable() ;
		$table->date('expected_harvest_date')->nullable() ;
		$table->text('fertilizer_plan')->nullable();
		$table->text('photo')->nullable();
		$table->text('description')->nullable();
		$table->datetime('created_at')->nullable() ;
		$table->datetime('updated_at')->nullable() ;
		$table->primary('id');

        });
    }

    public function down()
    {
        Schema::dropIfExists('active_crop');
    }
}
