<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContentTextOnContents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('teaching_contents', function(Blueprint $table){

			$table->string('content_text')->after('learning_style_id');
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

			$table->dropColumn('content_text');
		});
	}

}
