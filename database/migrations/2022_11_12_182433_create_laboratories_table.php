<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratoriesTable extends Migration {

	public function up()
	{
		Schema::create('laboratories', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('phone');
			$table->string('email');
			$table->string('officer_in_charge');
			$table->integer('clinic_id')->unsigned();
			$table->string('Specialization');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('laboratories');
	}
}