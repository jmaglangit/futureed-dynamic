<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeIsAccountReviewedToAccountStatus extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('clients', function(Blueprint $table)
		{
			$table->dropColumn('is_account_reviewed');
			$table->enum('account_status', ['Pending', 'Accepted', 'Rejected'])->default('Pending')->after('zip');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('clients', function(Blueprint $table)
		{
			$table->dropColumn('account_status');
			$table->tinyInteger('is_account_reviewed')->after('zip');
		});
	}

}
