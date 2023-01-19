<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentServicesTable extends Migration {

	public function up()
	{
		Schema::create('attachment_services', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('service_id');
			$table->string('name');
			$table->integer('serviceable_id');
			$table->string('serviceable_type');
			$table->decimal('cost');
			$table->decimal('amount');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('attachment_services');
	}
}