<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateModuleContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE module_contents change area_id subject_area_id INTEGER NOT NULL;");

		Schema::table('module_contents', function(Blueprint $table){

			$table->dropColumn('grade_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE module_contents change subject_area_id area_id BIGINT NOT NULL;");

		Schema::table('module_contents', function(Blueprint $table){

			$table->bigInteger('grade_id')->after('subject_id');
		});
	}

}
