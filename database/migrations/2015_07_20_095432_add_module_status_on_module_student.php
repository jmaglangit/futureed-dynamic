<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModuleStatusOnModuleStudent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('student_modules', function(Blueprint $table){

			$table->enum('module_status', ['Available', 'On Going', 'Completed'])->after('module_id');
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

			$table->dropColumn('module_status');
		});
	}

}
