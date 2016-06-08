<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPackageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscription_packages', function(Blueprint $table){

			$table->bigIncrements('id');
			$table->bigInteger('subject_id');
			$table->bigInteger('days_id');
			$table->bigInteger('subscription_id');
			$table->bigInteger('country_id');
			$table->decimal('price',8,2);
			$table->enum('status', ['Enabled', 'Disabled']);
			$table->bigInteger('created_by');
			$table->bigInteger('updated_by');
			$table->timestamps();
			$table->softDeletes()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subscription_packages');
	}

}
