<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalEnumFieldModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE questions CHANGE  question_type question_type enum('MC','FIB','O','N','GR','QUAD', 'COD') ;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE questions CHANGE  question_type question_type enum('MC','FIB','O','N','GR','QUAD') ;");
	}

}
