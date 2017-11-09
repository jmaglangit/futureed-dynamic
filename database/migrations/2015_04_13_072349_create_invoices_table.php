<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoices', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_no');
            $table->timestamp('invoice_date');
            $table->bigInteger('invoice_no');
            $table->bigInteger('client_id');
            $table->string('client_name',128);
            $table->timestamp('date_start');
            $table->timestamp('date_end');
            $table->smallInteger('seats_total');
            $table->enum('discount_type',['Volume', 'Client']);
            $table->bigInteger('discount_id');
            $table->decimal('discount',5,2);
            $table->decimal('total_amount',8,2);
            $table->bigInteger('subscription_id');
            $table->enum('payment_status',['Pending', 'Paid', 'Cancelled']);
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
		Schema::drop('invoices');
	}

}
