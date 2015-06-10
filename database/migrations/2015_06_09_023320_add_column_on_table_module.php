<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnTableModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('modules', function(Blueprint $table) {

			$table->bigInteger('subject_id')->after('id');
			$table->bigInteger('area_id')->after('subject_id');
			$table->bigInteger('grade_id')->after('area_id');

			$table->dropColumn(['subject_code','area_code','grade_code']);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('modules', function(Blueprint $table) {

			$table->bigInteger('subject_code');
			$table->bigInteger('area_code');
			$table->bigInteger('grade_code');

			$table->dropColumn(['subject_id','area_id','grade_id']);

		});
	}

}
