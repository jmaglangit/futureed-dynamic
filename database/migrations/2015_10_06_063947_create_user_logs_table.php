<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_logs',function(Blueprint $table){

			$table->bigIncrements('id');
			$table->bigInteger('user_id');
			$table->string('username');
			$table->string('email');
			$table->string('name')->nullable();
			$table->enum('user_type',[config('futureed.client'),config('futureed.student')]);
			$table->text('page_accessed');
			$table->text('api_accessed');
			$table->integer('result_response');
			$table->enum('status',[config('futureed.enabled'),config('futureed.disabled')]);
			$table->bigInteger('created_by');
			$table->bigInteger('updated_by');
			$table->softDeletes();
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
		Schema::drop('user_logs');
	}

}
