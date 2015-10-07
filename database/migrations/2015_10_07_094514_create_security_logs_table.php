<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecurityLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('security_logs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user_id');
			$table->string('username');
			$table->text('client_ip');
			$table->bigInteger('client_port');
			$table->text('proxy_ip');
			$table->text('client_user_agent');
			$table->text('url');
			$table->integer('result_response');
			$table->bigInteger('data_size_transferred');
			$table->enum('log_type',[config('futureed.user_log'),config('futureed.admin_log')]);
			$table->integer('lod_id');
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
		Schema::drop('security_logs');
	}

}
