<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnGradecodeAddGradeidInvoiceDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invoice_details', function(Blueprint $table)
		{
			$table->bigInteger('grade_id')->after('class_id');
			$table->dropColumn('grade_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('invoice_details', function(Blueprint $table)
		{
			$table->dropColumn('grade_id');
			$table->bigInteger('grade_code');
		});
	}

}
