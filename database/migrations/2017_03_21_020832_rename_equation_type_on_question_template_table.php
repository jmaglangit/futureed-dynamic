<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameEquationTypeOnQuestionTemplateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE question_template CHANGE equation_type question_type enum('FIB', 'MC') ;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */	
	public function down()
	{
		DB::statement("ALTER TABLE question_template CHANGE equation_type question_type enum('FIB', 'MC') ;");
	}
}
