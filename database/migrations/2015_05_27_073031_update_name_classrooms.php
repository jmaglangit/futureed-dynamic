<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNameClassrooms extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('classrooms', function(Blueprint $table)
        {
            $table->dropColumn('name');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
    {
        Schema::table('classrooms', function (Blueprint $table) {

            $table->string('name',128);



        });
    }

}
