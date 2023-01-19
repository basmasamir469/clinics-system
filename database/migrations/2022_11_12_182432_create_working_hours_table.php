<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingHoursTable extends Migration {

	public function up()
	{
		Schema::create('working_hours', function(Blueprint $table) {
			$table->increments('id');
			$table->string('day');
			$table->integer('working_hours');
			$table->time('from');
			$table->time('to');
			$table->integer('clinic_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('working_hours');
	}
}