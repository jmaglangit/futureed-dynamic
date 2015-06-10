<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarIdOnTableAvatarPoses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('avatar_poses', function(Blueprint $table) {

			$table->bigInteger('avatar_id')->after('id');

			$table->dropColumn('avatar_code');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('avatar_poses', function(Blueprint $table) {

			$table->dropColumn('avatar_id');

			$table->bigInteger('avatar_code');

		});

	}

}
