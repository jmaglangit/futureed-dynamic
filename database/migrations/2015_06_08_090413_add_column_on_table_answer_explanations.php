<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnTableAnswerExplanations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('answer_explanations',function(Blueprint $table){

			$table->bigInteger('module_id')->after('id');
			$table->bigInteger('question_id')->after('module_id');
			$table->bigInteger('answer_id')->after('question_id');
			$table->bigInteger('learning_style_id')->after('answer_id');

			$table->dropColumn('module_code','question_code','answer_code','learning_style_code');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('answer_explanations',function(Blueprint $table){

			$table->dropColumn('module_id','question_id','answer_id','learning_style_id');

			$table->bigInteger('module_code');
			$table->bigInteger('question_code');
			$table->bigInteger('answer_code');
			$table->bigInteger('learning_style_code')->nullable();

		});
	}

}
