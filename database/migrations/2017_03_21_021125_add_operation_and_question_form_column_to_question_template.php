<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOperationAndQuestionFormColumnToQuestionTemplate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('question_template', function(Blueprint $table){
			$table->enum('operation',['ADD'])->after('question_equation');
			$table->enum('question_form',['WORD', 'SERIES', 'BLANK'])->after('operation');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('question_template', function(Blueprint $table){
			$table->dropColumn('operation');
			$table->dropColumn('question_form');
		});
	}

}
