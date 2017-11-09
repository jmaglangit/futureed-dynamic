<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeZipCodeTypeOnSchoolsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('schools',function(Blueprint $table){

			$table->dropColumn('zip');
		});

		Schema::table('schools',function(Blueprint $table){

			$table->string('zip',10)->nullable()->after('country');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('schools',function(Blueprint $table){

			$table->dropColumn('zip');
		});

		Schema::table('schools',function(Blueprint $table){

			$table->integer('zip')->nullable()->after('country');
		});
	}

}
