<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableInvoiceDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::table('invoice_details', function(Blueprint $table)
        {
            $table->dropColumn('class_name','seats_total','sub_total');

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
            $table->dropColumn('class_name','seats_total','sub_total');

        });
    }

}
