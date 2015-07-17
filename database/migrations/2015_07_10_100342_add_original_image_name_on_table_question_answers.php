<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOriginalImageNameOnTableQuestionAnswers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('question_answers', function(Blueprint $table){
			$table->string('original_image_name')->after('answer_image');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('question_answers', function(Blueprint $table){
			$table->dropColumn('original_image_name');
		});
	}

}
