<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentBadgesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('student_badges', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('student_id');
            $table->bigInteger('badge_id');
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
		Schema::drop('student_badges');
	}

}
