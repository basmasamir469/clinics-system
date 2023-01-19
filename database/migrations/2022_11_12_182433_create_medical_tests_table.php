<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalTestsTable extends Migration {

	public function up()
	{
		Schema::create('medical_tests', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('clinic_id')->unsigned();
			$table->integer('patient_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('medical_tests');
	}
}