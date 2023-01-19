<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratoryUsersTable extends Migration {

	public function up()
	{
		Schema::create('laboratory_users', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('laboratory_id')->unsigned();
			$table->string('name');
			$table->string('phone');
			$table->string('password');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('laboratory_users');
	}
}