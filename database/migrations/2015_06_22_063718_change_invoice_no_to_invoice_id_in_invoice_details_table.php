<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeInvoiceNoToInvoiceIdInInvoiceDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('invoice_details', function(Blueprint $table)
        {
            $table->dropColumn('invoice_no');
            $table->bigInteger('invoice_id')->after('id');
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
            $table->bigInteger('invoice_no')->after('id');
            $table->dropColumn('invoice_id');
        });
	}

}
