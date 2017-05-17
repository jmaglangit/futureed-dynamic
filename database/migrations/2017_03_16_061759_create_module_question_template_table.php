<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateModuleQuestionTemplateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('module_question_template',function(Blueprint $table){
			$table->bigIncrements('id');
			$table->integer('question_template_id');
			$table->text('template');
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
		Schema::drop('module_question_template');
	}

}
