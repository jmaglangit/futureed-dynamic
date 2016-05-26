<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAnswerExplainationTableOnRequiredColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE answer_explanations CHANGE learning_style_id learning_style_id INTEGER ");
		DB::statement("ALTER TABLE answer_explanations CHANGE answer_id answer_id INTEGER ");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE answer_explanations CHANGE learning_style_id learning_style_id INTEGER NOT NULL");
		DB::statement("ALTER TABLE answer_explanations CHANGE answer_id answer_id INTEGER NOT NULL");
	}

}
