<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('student_modules', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('class_id');
            $table->bigInteger('student_id');
            $table->bigInteger('module_code');
            $table->tinyInteger	('progress');
            $table->timestamp('date_start');
            $table->timestamp('date_end');
            $table->integer('total_time');
            $table->smallInteger('no_of_mistakes');
            $table->integer('total_points_lost');
            $table->bigInteger('last_answered_question_id');
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->softDeletes()->nullable();
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
		Schema::drop('student_modules');
	}

}
