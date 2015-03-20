<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('module_code');
            $table->bigInteger('code')->nullable();
            $table->enum('question_type', ['MC', 'FIB', 'O', 'N']);
            $table->string('questions_text', 256);
            $table->string('questions_image', 256);
            $table->bigInteger('seq_no');
            $table->tinyInteger('difficulty');
            $table->integer('points_earned');
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
		Schema::drop('questions');
	}

}
