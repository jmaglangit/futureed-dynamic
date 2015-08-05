<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('modules', function(Blueprint $table){

			$table->dropColumn('grade_id');
			$table->integer('points_earned')->after('common_core_url');
		});


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('modules', function(Blueprint $table){

			$table->dropColumn('points_earned');
			$table->bigInteger('grade_id')->after('subject_area_id');
		});
	}

}
