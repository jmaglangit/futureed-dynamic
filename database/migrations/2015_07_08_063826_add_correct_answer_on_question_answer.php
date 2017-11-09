<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCorrectAnswerOnQuestionAnswer extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('question_answers', function(Blueprint $table){

			$table->enum('correct_answer',['Yes','No'])->after('answer_image');
			$table->dropColumn('correct_flag');
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

			$table->tinyInteger('correct_flag');
			$table->dropColumn('correct_answer');
		});
	}

}
