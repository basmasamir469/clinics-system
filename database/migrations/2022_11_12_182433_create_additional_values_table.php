<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalValuesTable extends Migration {

	public function up()
	{
		Schema::create('additional_values', function(Blueprint $table) {
			$table->increments('id');
			// $table->tinyInteger('type');
			$table->string('addvalue');
			$table->integer('additionable_id');
			$table->string('additionable_type');
			$table->integer('addition_id');
			// $table->integer('clinic_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('additional_values');
	}
}