<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubjectIdAgeGroupIdInBadges extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('badges', function(Blueprint $table){

			$table->bigInteger('subject_id')->after('name')->nullable();
			$table->bigInteger('age_group_id')->after('subject_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('badges', function(Blueprint $table){

			$table->dropColumn(['subject_id','age_group_id']);
		});
	}

}
