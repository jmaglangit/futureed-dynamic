<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubjectAreaIdOnTableModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('modules', function(Blueprint $table) {

			$table->bigInteger('subject_area_id')->after('subject_id');
			$table->dropColumn('area_id');

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

			$table->bigInteger('area_id')->after('subject_id');
			$table->dropColumn('subject_area_id');

		});
	}

}
