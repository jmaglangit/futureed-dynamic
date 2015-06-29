<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeParentStudentColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('parent_students',function(Blueprint $table){
			$table->dropColumn(['parent_user_id','student_user_id']);
		});

		Schema::table('parent_students',function(Blueprint $table){
			$table->bigInteger('parent_id')->after('id');
			$table->bigInteger('student_id')->after('parent_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('parent_students',function(Blueprint $table){
			$table->dropColumn(['parent_id','student_id']);
		});

		Schema::table('parent_students',function(Blueprint $table){
			$table->bigInteger('parent_user_id')->after('id');
			$table->bigInteger('student_user_id')->after('parent_user_id');
		});

	}

}
