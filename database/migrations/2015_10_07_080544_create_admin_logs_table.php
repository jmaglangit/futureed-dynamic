<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_logs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user_id');
			$table->string('username');
			$table->string('email');
			$table->string('name')->nullable();
			$table->enum('admin_type',[config('futureed.admin_role_admin'),config('futureed.admin_role_super_admin')]);
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
		Schema::drop('admin_logs');
	}

}
