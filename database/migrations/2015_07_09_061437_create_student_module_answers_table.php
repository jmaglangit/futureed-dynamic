<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentModuleAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('student_module_answers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('student_module_id');
			$table->bigInteger('module_id');
			$table->bigIncrements('seq_no');
			$table->bigInteger('question_id');
			$table->bigInteger('answer_id');
			$table->text('answer_text');
			$table->integer('points_earned');
			$table->timestamp('date_start');
			$table->timestamp('date_end');
			$table->integer('total_time');
			$table->enum('answer_status',['Correct','Wrong']);
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
		Schema::drop('student_module_answers');
	}

}
