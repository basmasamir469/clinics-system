<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{

	public function up()
	{
		Schema::create('services', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('cost');
			$table->integer('clinic_id')->unsigned();
			$table->string('service_type');
			$table->tinyInteger('status')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('services');
	}
}
