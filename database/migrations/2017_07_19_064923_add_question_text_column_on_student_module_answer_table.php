<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionTextColumnOnStudentModuleAnswerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('student_module_answers', function(Blueprint $table){
			$table->text('question_text')->nullable()->after('answer_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('student_module_answers', function(Blueprint $table){
			$table->dropColumn('question_text');
		});
	}

}
