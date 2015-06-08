<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRegistrationVerificationTokenIntoRegistrationTokenOnUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users',function(Blueprint $table){

			$table->dropColumn('registration_verification_token');
			$table->string('registration_token',256)->nullable()->after('password_reset_token');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users',function(Blueprint $table){

			$table->dropColumn('registration_token');
			$table->string('registration_verification_token',256)->nullable()->after('password_reset_token');
		});
	}

}
