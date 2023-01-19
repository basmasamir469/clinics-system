<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration {

	public function up()
	{
		Schema::create('areas', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('clinic_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('areas');
	}
}