<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCorrectCounterInStudentModuleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('student_modules', function (Blueprint $table){
            $table->smallInteger('correct_counter')->after('wrong_counter');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('student_modules', function (Blueprint $table){
            $table->dropColumn('correct_counter');
        });
	}

}
