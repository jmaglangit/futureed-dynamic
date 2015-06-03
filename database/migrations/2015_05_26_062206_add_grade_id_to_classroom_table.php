<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGradeIdToClassroomTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::table('classrooms', function(Blueprint $table)
        {
            $table->bigInteger('grade_id')->after('name');
            $table->dropColumn('grade_code');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
        Schema::table('classrooms', function(Blueprint $table)
        {

            $table->dropColumn('grade_id');
            $table->bigInteger('grade_code')->after('name');
        });
	}

}
