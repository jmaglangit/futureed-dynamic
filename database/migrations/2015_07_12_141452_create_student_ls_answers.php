<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentLsAnswers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('student_ls_answers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('student_id');
			$table->bigInteger('ls_test_id');
			$table->bigInteger('ls_section_id')->nullable();
			$table->integer('ls_seq_no')->nullable();
			$table->bigInteger('ls_test_question_id')->nullable();
			$table->bigInteger('ls_question_code_id')->nullable();
			$table->bigInteger('ls_question_code_detail_id')->nullable();
			$table->bigInteger('ls_question_answer_id')->nullable();
			$table->text('ls_answer_text')->nullable();
			$table->integer('ls_raw_score')->nullable();
			$table->bigInteger('created_by');
			$table->bigInteger('updated_by');
			$table->timestamps();
			$table->softDeletes()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('student_ls_answers');
	}

}
