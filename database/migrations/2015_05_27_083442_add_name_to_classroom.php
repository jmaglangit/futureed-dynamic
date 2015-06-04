<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameToClassroom extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('classrooms', function (Blueprint $table) {

            $table->string('name', 128)->nullable()->after('order_no');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('classrooms', function(Blueprint $table)
        {
            $table->dropColumn('name');

        });
	}

}
