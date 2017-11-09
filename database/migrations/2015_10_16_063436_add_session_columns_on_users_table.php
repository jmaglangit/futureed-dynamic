<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSessionColumnsOnUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function (Blueprint $table){

			$table->tinyInteger('impersonate')->nullable()->after('timezone');
			$table->tinyInteger('impersonated_by')->nullable()->after('impersonate');
			$table->text('session_token')->nullable()->after('impersonated_by');
			$table->timestamp('last_activity')->nullable()->after('session_token');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function (Blueprint $table){

			$table->dropColumn(['session_token','last_activity','impersonate','impersonated_by']);
		});
	}

}
