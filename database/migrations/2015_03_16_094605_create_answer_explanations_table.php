<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerExplanationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('answer_explanations', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('module_code');
            $table->bigInteger('question_code');
            $table->bigInteger('answer_code');
            $table->bigInteger('learning_style_code')->nullable();
            $table->bigInteger('seq_no');
            $table->text('answer_explanation');
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
		Schema::drop('answer_explanations');
	}

}
