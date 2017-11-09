<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSubjectCodeToSubjectIdSubjectAreas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subject_areas', function(Blueprint $table)
		{
			$table->bigInteger('subject_id')->after('id');
			$table->dropColumn('subject_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subject_areas', function(Blueprint $table)
		{
			$table->dropColumn('subject_id');
			$table->bigInteger('subject_code')->after('id');
		});
	}

}
