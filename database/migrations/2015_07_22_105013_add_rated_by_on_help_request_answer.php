<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRatedByOnHelpRequestAnswer extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('help_request_answers', function(Blueprint $table) {

			$table->enum('rated_by', ['Teacher','Admin'])->after('request_answer_status');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('help_request_answers', function(Blueprint $table) {

			$table->dropColumn('rated_by');

		});
	}

}
