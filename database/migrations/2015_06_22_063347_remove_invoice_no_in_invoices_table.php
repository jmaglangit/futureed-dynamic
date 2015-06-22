<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveInvoiceNoInInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('invoices', function(Blueprint $table)
        {
            $table->dropColumn('invoice_no');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('invoices', function(Blueprint $table)
        {
            $table->bigInteger('invoice_no')->after('invoice_date');
        });
	}

}
