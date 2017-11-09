<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriptionStatusOnClassStudentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('class_students', function(Blueprint $table){
			$table->enum('subscription_status', ['Active','Inactive'])->after('class_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('class_students', function(Blueprint $table){
			$table->dropColumn('subscription_status');
		});
	}

}
