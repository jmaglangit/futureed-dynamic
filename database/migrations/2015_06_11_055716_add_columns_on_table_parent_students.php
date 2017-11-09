<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOnTableParentStudents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('parent_students', function(Blueprint $table) {

			$table->bigInteger('invitation_code')->after('student_user_id');
			$table->enum('status',['Enabled','Disabled'])->after('invitation_code');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('parent_students', function(Blueprint $table) {

			$table->dropColumn(['invitation_code','status']);
		});
	}

}
