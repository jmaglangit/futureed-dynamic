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
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->enum('gender', ['Male', 'Female']);
            $table->date('birth_date');
            $table->string('country', 128)->nullable();
            $table->string('state', 128)->nullable();
            $table->string('city', 128)->nullable();
            $table->bigInteger('avatar_id')->nullable();
            $table->tinyInteger('password_image_id')->nullable();
            $table->tinyInteger('parent_id')->nullable();
            $table->bigInteger('school_code');
            $table->bigInteger('grade_code');
            $table->integer('points')->nullable();
            $table->bigInteger('point_level_id')->nullable();
            $table->bigInteger('learning_style_id')->nullable();
            $table->enum('status', ['Enabled', 'Disabled']);
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
		Schema::drop('students');
	}

}
