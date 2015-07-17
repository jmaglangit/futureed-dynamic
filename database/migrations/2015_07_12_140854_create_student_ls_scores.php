<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentLsScores extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('student_ls_scores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('student_id');
			$table->bigInteger('ls_test_id');
			$table->string('ls_group', 50)->nullable();
			$table->string('ls_name', 50)->nullable();
			$table->integer('ls_seq_no')->nullable();
			$table->integer('ls_std_score')->nullable();
			$table->string('ls_banding', 256)->nullable();
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
		Schema::drop('student_ls_scores');
	}

}
