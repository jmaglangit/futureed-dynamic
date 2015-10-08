<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQuestionsTableAddGROnQuestionType extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE questions CHANGE question_type question_type ENUM('MC','FIB','O','N','GR');");

		Schema::table('questions', function(Blueprint $table){

			$table->text('question_graph_image')->nullable()->after('question_order_text');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE questions CHANGE question_type question_type ENUM('MC','FIB','O','N');");

		Schema::table('questions', function(Blueprint $table){

			$table->dropColumn('question_graph_image');
		});
	}

}
