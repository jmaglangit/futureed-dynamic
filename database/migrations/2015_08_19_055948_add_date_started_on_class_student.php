<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateStartedOnClassStudent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('class_students', function(Blueprint $table){

			$table->timestamp('date_started')->nullable()->after('class_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('class_students', function(Blueprint $table){

			$table->dropColumn('date_started');
		});
	}

}
