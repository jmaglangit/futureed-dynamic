<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateQuestionAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE question_answers CHANGE answer_text answer_text TEXT NOT NULL;");

		Schema::table('question_answers', function(Blueprint $table){

			$table->string('label',20)->nullable()->after('code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE question_answers CHANGE answer_text answer_text VARCHAR(64) NOT NULL;");

		Schema::table('question_answers', function(Blueprint $table){

			$table->dropColumn('label');
		});
	}

}
