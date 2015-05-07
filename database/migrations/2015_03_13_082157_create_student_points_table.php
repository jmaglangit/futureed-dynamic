<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentPointsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('student_points', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('student_id');
            $table->integer('points_earned');
            $table->bigInteger('event_id');
            $table->string('description', 256);
            $table->timestamp('earned_at');
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
		Schema::drop('student_points');
	}

}
