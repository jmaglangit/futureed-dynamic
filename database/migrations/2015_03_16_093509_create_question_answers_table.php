<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_answers', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('module_code');
            $table->bigInteger('question_code');
            $table->bigInteger('code')->nullable();
            $table->string('answer_text', 64);
            $table->string('answer_image', 256);
            $table->tinyInteger('correct_flag');
            $table->integer('point_equivalent');
            $table->bigInteger('created_by_id');
            $table->bigInteger('updated_by_id');
            $table->timestamp('delete_at');
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
		Schema::drop('question_answers');
	}

}
