<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipStatusOnTips extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tips', function(Blueprint $table) {

			$table->enum('tip_status', ['Pending','Rejected','Verified'])->after('rating');
			$table->bigInteger('subject_area_id')->after('subject_id');
			$table->dropColumn(['is_verified','area_id']);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tips', function(Blueprint $table) {

			$table->bigInteger('is_verified');
			$table->bigInteger('area_id');
			$table->dropColumn(['tip_status','subject_area_id']);
		});
	}

}
