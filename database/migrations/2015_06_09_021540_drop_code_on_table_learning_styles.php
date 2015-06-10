<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropCodeOnTableLearningStyles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('learning_styles', function(Blueprint $table) {

			$table->dropColumn('code');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('learning_styles', function(Blueprint $table) {

			$table->bigInteger('code');

		});
		;
	}

}
