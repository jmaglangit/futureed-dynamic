<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeParentStudentColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE parent_students change parent_user_id parent_id INTEGER ;");
		DB::statement("ALTER TABLE parent_students change student_user_id student_id INTEGER ;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE parent_students change parent_id parent_user_id INTEGER ;");
		DB::statement("ALTER TABLE parent_students change student_id student_user_id INTEGER ;");
	}

}
