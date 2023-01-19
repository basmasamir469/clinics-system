<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('duration');
			$table->decimal('cost');
			$table->integer('working_hours_id')->unsigned();
			$table->integer('clinic_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}