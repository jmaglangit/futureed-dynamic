<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachingContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('teaching_contents', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('module_code');
            $table->bigInteger('subject_code');
            $table->bigInteger('grade_code');
            $table->bigInteger('area_code');
            $table->bigInteger('code')->nullable();
            $table->string('teaching_module', 64);
            $table->string('description', 256);
            $table->bigInteger('learning_style_code')->nullable();
            $table->string('content_url', 256);
            $table->bigInteger('media_type_code');
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
		Schema::drop('teaching_contents');
	}

}
