<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnTableQuestionAnswers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('question_answers', function(Blueprint $table) {

			$table->bigInteger('module_id')->after('id');
			$table->bigInteger('question_id')->after('module_id');

			$table->dropColumn('module_code','question_code');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('question_answers', function(Blueprint $table) {

			$table->dropColumn('module_id','question_id');

			$table->bigInteger('module_code');
			$table->bigInteger('question_code');



		});
	}

}
