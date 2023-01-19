<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration {

	public function up()
	{
		Schema::create('insurances', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->decimal('insurance_discount_percentage');
			$table->decimal('patient_discount_percentage');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('insurances');
	}
}