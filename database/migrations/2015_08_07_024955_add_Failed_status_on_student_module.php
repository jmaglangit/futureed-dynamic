<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFailedStatusOnStudentModule extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE student_modules CHANGE module_status module_status ENUM('Available','On Going','Completed','Failed');");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("UPDATE student_modules set module_status = NULL WHERE module_status='Failed';");
		DB::statement("ALTER TABLE student_modules CHANGE module_status module_status ENUM('Available','On Going','Completed');");
	}

}
