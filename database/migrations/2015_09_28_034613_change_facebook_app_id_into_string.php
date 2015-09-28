<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFacebookAppIdIntoString extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE users change facebook_app_id facebook_app_id VARCHAR(255);");
	}

	/**
	 * Reverse the migrations.

	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE users change facebook_app_id facebook_app_id BIGINT;");
	}

}
