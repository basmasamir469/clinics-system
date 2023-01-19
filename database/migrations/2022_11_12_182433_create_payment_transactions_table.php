<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionsTable extends Migration
{

	public function up()
	{
		Schema::create('payment_transactions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('safe_id')->default('1');
			$table->integer('clinic_id')->unsigned();
			$table->date('pay_date');
			$table->tinyInteger('effect');
			$table->tinyInteger('type');
			$table->decimal('amount');
			$table->morphs('paymentable');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('payment_transactions');
	}
}
