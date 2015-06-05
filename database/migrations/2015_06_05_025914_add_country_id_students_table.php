<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryIdStudentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('students',function(Blueprint $table){

            $table->bigInteger('country_id')->after('birth_date');
        } );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('students', function(Blueprint $table){

            $table->dropColumn('country_id');
        });
	}

}
