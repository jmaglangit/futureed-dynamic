<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnTableStudentModules extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('student_modules', function(Blueprint $table) {

			$table->bigInteger('module_id')->after('student_id');

			$table->dropColumn('module_code');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('student_modules', function(Blueprint $table) {

			$table->dropColumn('module_id');

			$table->bigInteger('module_code');

		});
	}

}
