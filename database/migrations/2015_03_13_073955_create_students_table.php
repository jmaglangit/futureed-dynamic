<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->enum('gender', ['Male', 'Female']);
            $table->datetime('birth_date');
            $table->bigInteger('avatar_id');
            $table->tinyInteger('password_image_id');
            $table->bigInteger('school_code');
            $table->bigInteger('grade_code');
            $table->integer('points');
            $table->bigInteger('point_level_id')->nullable();
            $table->bigInteger('learning_style_id');
            $table->enum('status', ['Enabled', 'Disabled']);
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamp('deleted_at');
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
		Schema::drop('students');
	}

}
