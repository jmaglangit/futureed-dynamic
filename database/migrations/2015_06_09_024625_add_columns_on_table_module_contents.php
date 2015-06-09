<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOnTableModuleContents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('module_contents', function(Blueprint $table) {

			$table->bigInteger('module_id')->after('id');
			$table->bigInteger('subject_id')->after('module_id');
			$table->bigInteger('grade_id')->after('subject_id');
			$table->bigInteger('area_id')->after('grade_id');
			$table->bigInteger('content_id')->after('area_id');

			$table->dropColumn('module_code','subject_code','area_code','grade_code','content_code');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('module_contents', function(Blueprint $table) {

			$table->bigInteger('module_code');
			$table->bigInteger('subject_code');
			$table->bigInteger('grade_code');
			$table->bigInteger('area_code');
			$table->bigInteger('content_code');

			$table->dropColumn('module_id','subject_id','area_id','grade_id','content_id');

		});
	}

}
