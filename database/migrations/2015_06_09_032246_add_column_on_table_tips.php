<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnTableTips extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tips', function(Blueprint $table) {

			$table->bigInteger('module_id')->after('content');
			$table->bigInteger('subject_id')->after('module_id');
			$table->bigInteger('area_id')->after('subject_id');

			$table->dropColumn('module_code','subject_code','area_code');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tips', function(Blueprint $table) {

			$table->dropColumn('module_id','subject_id','area_id');

			$table->bigInteger('module_code');
			$table->bigInteger('subject_code');
			$table->bigInteger('area_code');
			
		});

	}

}
