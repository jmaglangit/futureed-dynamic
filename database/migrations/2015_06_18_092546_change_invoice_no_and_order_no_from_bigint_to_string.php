<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeInvoiceNoAndOrderNoFromBigintToString extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        //Drop columns.
        Schema::table('invoices', function(Blueprint $table)
        {
            $table->dropColumn('order_no');
            $table->dropColumn('invoice_no');
        });

        Schema::table('invoice_details', function(Blueprint $table)
        {
            $table->dropColumn('invoice_no');
        });

        Schema::table('orders', function(Blueprint $table)
        {
            $table->dropColumn('order_no');
        });

        Schema::table('classrooms', function(Blueprint $table)
        {
            $table->dropColumn('order_no');
        });

        //Add columns with different data type.

        Schema::table('invoices', function(Blueprint $table)
        {
            $table->string('order_no',20)->after('id');
            $table->string('invoice_no',20)->after('invoice_date');
        });

        Schema::table('invoice_details', function(Blueprint $table)
        {
            $table->string('invoice_no',20)->after('id');
        });

        Schema::table('orders', function(Blueprint $table)
        {
            $table->string('order_no',20)->after('id');
        });

        Schema::table('classrooms', function(Blueprint $table)
        {
            $table->string('order_no',20)->after('id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        //Drop columns.
        Schema::table('invoices', function(Blueprint $table)
        {
            $table->dropColumn('order_no');
            $table->dropColumn('invoice_no');
        });

        Schema::table('invoice_details', function(Blueprint $table)
        {
            $table->dropColumn('invoice_no');
        });

        Schema::table('orders', function(Blueprint $table)
        {
            $table->dropColumn('order_no');
        });

        Schema::table('classrooms', function(Blueprint $table)
        {
            $table->dropColumn('order_no');
        });

        //Add columns with different data type.

        Schema::table('invoices', function(Blueprint $table)
        {
            $table->bigInteger('order_no')->after('id');
            $table->bigInteger('invoice_no')->after('invoice_date');
        });

        Schema::table('invoice_details', function(Blueprint $table)
        {
            $table->bigInteger('invoice_no')->after('id');
        });

        Schema::table('orders', function(Blueprint $table)
        {
            $table->bigInteger('order_no')->after('id');
        });

        Schema::table('classrooms', function(Blueprint $table)
        {
            $table->bigInteger('order_no')->after('id');
        });
	}

}
