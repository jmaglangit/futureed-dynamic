<?php

use Illuminate\Database\Migrations\Migration;

class ModifyStatusEnumOptionsFromSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subscription', function($table)
        {
            DB::statement("ALTER TABLE subscription MODIFY COLUMN status ENUM('Enabled','Disabled') NOT NULL");
        });            
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::table('subscription', function($table)
        {
            DB::statement("ALTER TABLE subscription MODIFY COLUMN status ENUM('Enabled','Diabled') NOT NULL");
        });
	}
}
