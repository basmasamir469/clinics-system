<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{

	public function up()
	{
		Schema::create('appointments', function (Blueprint $table) {
			$table->increments('id');
			$table->date('appointment_date');
			$table->time('appointment_time');
			$table->tinyInteger('status')->default(0);
			$table->string('visit_results')->nullable();
			$table->decimal('advance_payment')->nullable();
			$table->integer('clinic_id')->unsigned();
			$table->integer('patient_id')->unsigned();
			$table->text('notes');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('appointments');
	}
}
