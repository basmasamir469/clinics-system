<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentServiceTable extends Migration
{

	public function up()
	{
		Schema::create('appointment_service', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('appointment_id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->decimal('cost');
			$table->decimal('cost_after_insurance');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('appointment_service');
	}
}
