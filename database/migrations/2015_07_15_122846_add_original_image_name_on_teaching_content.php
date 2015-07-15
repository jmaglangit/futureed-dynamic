<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOriginalImageNameOnTeachingContent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('teaching_contents', function(Blueprint $table){

			$table->string('original_image_name')->after('content_url');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('teaching_contents', function(Blueprint $table){

			$table->dropColumn('original_image_name');
		});
	}

}
