<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropCodeOnTableMediaTypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('media_types', function(Blueprint $table) {

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
		Schema::table('media_types', function(Blueprint $table) {

			$table->bigInteger('code')->nullable();

		});
	}

}
