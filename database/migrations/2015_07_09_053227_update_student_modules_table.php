<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStudentModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('student_modules', function (Blueprint $table){

			//Drop
			$table->dropColumn(['no_of_mistakes','total_points_lost']);

			//Add
			$table->bigInteger('question_counter')->after('total_time');
			$table->smallInteger('wrong_counter')->after('question_counter');
			$table->integer('running_points')->after('wrong_counter');
			$table->integer('points_earned')->after('running_points');


		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('student_modules', function(Blueprint $table){

			//Add
			$table->smallInteger('no_of_mistakes')->after('total_time');
			$table->integer('total_points_lost')->after('total_points_lost');

			//Drop
			$table->dropColumn(['question_counter','wrong_counter','running_points','points_earned']);

		});
	}

}
