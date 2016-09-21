<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddTranslatableColumnOnModuleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('modules',function(Blueprint $table){
			$table->integer('translatable')->after('points_to_finish');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('modules',function(Blueprint $table){
			$table->dropColumn('translatable');
		});
	}

}
