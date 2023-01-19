<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugsTable extends Migration {

	public function up()
	{
		Schema::create('drugs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('concentration');
			$table->text('info');
			$table->integer('clinic_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('drugs');
	}
}