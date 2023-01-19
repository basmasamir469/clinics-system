<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{

	public function up()
	{
		Schema::create('patients', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('phone');
			$table->date('date_of_birth');
			$table->boolean('gender');
			$table->integer('clinic_id')->unsigned();
			$table->string('email');
			$table->text('notes');
			$table->integer('insurance_id')->unsigned();
			$table->integer('area_id')->unsigned();
			$table->tinyInteger('status')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('patients');
	}
}
