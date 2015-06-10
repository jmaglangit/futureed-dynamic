<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnTableStudentAvatarAccessories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('student_avatar_accessories', function(Blueprint $table) {

			$table->bigInteger('avatar_accessories_id')->after('user_id');

			$table->dropColumn('avatar_accessories_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('student_avatar_accessories', function(Blueprint $table) {


			$table->dropColumn('avatar_accessories_id');

			$table->bigInteger('avatar_accessories_code');
		});
	}

}
