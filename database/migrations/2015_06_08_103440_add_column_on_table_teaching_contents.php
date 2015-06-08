<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnTableTeachingContents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('teaching_contents', function(Blueprint $table) {

			$table->bigInteger('module_id')->after('id');
			$table->bigInteger('subject_id')->after('module_id');
			$table->bigInteger('grade_id')->after('subject_id');
			$table->bigInteger('area_id')->after('grade_id');
			$table->bigInteger('learning_style_id')->after('description');
			$table->bigInteger('media_type_id')->after('content_url');

			$table->dropColumn('module_code','subject_code','grade_code','area_code',
				               'learning_style_code','media_type_code');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('teaching_contents', function(Blueprint $table) {

			$table->dropColumn('module_id','subject_id','grade_id','area_id',
							   'learning_style_id','media_type_id');

			$table->bigInteger('module_code');
			$table->bigInteger('subject_code');
			$table->bigInteger('grade_code');
			$table->bigInteger('area_code');
			$table->bigInteger('learning_style_code');
			$table->bigInteger('media_type_code');

		});
	}

}
