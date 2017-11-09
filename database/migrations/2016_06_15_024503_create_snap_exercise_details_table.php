<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnapExerciseDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('snap_exercise_details', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('classroom_id');
			$table->bigInteger('module_id');
			$table->bigInteger('order_id');
			$table->bigInteger('question_id');
			$table->bigInteger('question_seq_no');
			$table->bigInteger('student_module_id');
			$table->bigInteger('student_id');
			$table->boolean('is_exercise_completed')->default(false);
			$table->timestamp('date_start');
			$table->timestamp('date_end');
			$table->bigInteger('created_by');
			$table->bigInteger('updated_by');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('snap_exercise_details');
	}

}