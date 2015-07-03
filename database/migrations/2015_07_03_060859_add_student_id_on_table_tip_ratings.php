<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentIdOnTableTipRatings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tip_ratings', function(Blueprint $table) {

			$table->bigInteger('student_id')->after('id');
			$table->dropColumn('user_id');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tip_ratings', function(Blueprint $table) {

			$table->bigInteger('user_id');
			$table->dropColumn('student_id');

		});
	}

}
