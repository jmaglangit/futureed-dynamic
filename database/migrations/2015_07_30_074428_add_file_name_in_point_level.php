<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileNameInPointLevel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('point_levels', function(Blueprint $table){
			$table->string('filename',256)->nullable()->after('description');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('point_levels', function(Blueprint $table){
			$table->dropColumn('filename');
		});
	}

}
