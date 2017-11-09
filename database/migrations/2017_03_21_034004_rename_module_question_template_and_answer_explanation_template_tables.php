<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RenameModuleQuestionTemplateAndAnswerExplanationTemplateTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::rename('module_question_template','module_question_template_1');
		Schema::rename('answer_explanation_template','module_question_template');
		Schema::rename('module_question_template_1','answer_explanation_template');


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::rename('answer_explanation_template','answer_explanation_template_1');
		Schema::rename('module_question_template','answer_explanation_template');
		Schema::rename('answer_explanation_template_1','module_question_template');

	}

}
