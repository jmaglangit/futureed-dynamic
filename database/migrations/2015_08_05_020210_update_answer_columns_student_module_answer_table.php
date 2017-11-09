<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAnswerColumnsStudentModuleAnswerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE student_module_answers CHANGE answer_text answer_text TEXT;");
		DB::statement("ALTER TABLE student_module_answers CHANGE answer_id answer_id BIGINT;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE student_module_answers CHANGE answer_text answer_text TEXT NOT NULL;");
		DB::statement("ALTER TABLE student_module_answers CHANGE answer_id answer_id BIGINT NOT NULL;");
	}

}
