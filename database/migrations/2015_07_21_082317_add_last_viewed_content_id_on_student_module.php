<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastViewedContentIdOnStudentModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('student_modules', function(Blueprint $table){

			$table->bigInteger('last_viewed_content_id')->after('module_status')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('student_modules', function(Blueprint $table){

			$table->dropColumn('last_viewed_content_id');
		});
	}

}
