<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnCodeOnTableBadges extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('badges', function(Blueprint $table) {

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
		Schema::table('badges', function(Blueprint $table) {

			$table->bigInteger('code')->nullable()->after('id');

		});

	}

}
