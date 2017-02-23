<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDifficultyOnModuleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('modules', function(Blueprint $table){
			$table->tinyInteger('has_difficulty')->after('common_core_url');
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
			$table->dropColumn('has_difficulty');
		});
	}

}
