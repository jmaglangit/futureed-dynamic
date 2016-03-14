<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB as MySQL;

class ChangeStatusValueSubscriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subscription', function(Blueprint $table)
		{
			MySQL::statement("ALTER TABLE subscription CHANGE COLUMN status status ENUM('Enabled', 'Disabled')");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subscription', function(Blueprint $table)
		{
			MySQL::statement("ALTER TABLE subscription CHANGE COLUMN status status ENUM('Enabled', 'Diabled')");
		});
	}

}
