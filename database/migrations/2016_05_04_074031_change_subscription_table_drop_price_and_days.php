<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class ChangeSubscriptionTableDropPriceAndDays extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('subscription', function(Blueprint $table){

			$table->dropColumn(['price','days']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('subscription',function(Blueprint $table){

			$table->decimal('price',8,2)->after('name');
			$table->bigInteger('days')->after('description');
		});
	}

}
