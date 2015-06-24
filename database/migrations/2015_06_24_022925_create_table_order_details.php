<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrderDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_details',function(Blueprint $table){


			$table->bigIncrements('id');
			$table->bigInteger('order_id');
			$table->bigInteger('student_id');
			$table->decimal('price',5,2);
			$table->bigInteger('created_by');
			$table->bigInteger('updated_by');
			$table->softDeletes()->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_details');
	}

}
