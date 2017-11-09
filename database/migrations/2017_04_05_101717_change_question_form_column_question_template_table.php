<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeQuestionFormColumnQuestionTemplateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE question_template MODIFY COLUMN question_form ENUM('Blank','Series','Word')");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE question_template MODIFY COLUMN question_form ENUM('BLANK','SERIES','WORD')");
	}

}
