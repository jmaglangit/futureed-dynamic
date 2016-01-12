<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStudentBadgesTableIntoSubjectAndAgeGroup extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('student_badges', function(Blueprint $table){
			$table->bigInteger('subject_id')->after('student_id');
			$table->bigInteger('age_group_id')->after('subject_id');
			$table->dropColumn('badge_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('student_badges', function(Blueprint $table){
			$table->bigInteger('badge_id')->after('student_id');
			$table->dropColumn('subject_id','age_group_id');
		});
	}

}
