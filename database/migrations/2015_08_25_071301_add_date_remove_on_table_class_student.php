<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateRemoveOnTableClassStudent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('class_students', function(Blueprint $table){

			$table->timestamp('date_removed')->nullable()->after('date_started');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('class_students', function(Blueprint $table ){

			$table->dropColumn('date_removed');
		});
	}

}
