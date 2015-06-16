<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnVerificationCodeInClassStudent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('class_students', function(Blueprint $table)
        {
            $table->dropColumn('verification_code');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('class_students', function(Blueprint $table)
        {
            $table->bigInteger('verification_code')->after('status');
        });
	}

}
