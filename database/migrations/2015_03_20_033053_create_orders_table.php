<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_no');
            $table->timestamp('order_date');
            $table->bigInteger('client_id');
            $table->bigInteger('subscription_id');
            $table->timestamp('date_start');
            $table->timestamp('date_end');
            $table->smallInteger('seats_total');
            $table->smallInteger('seats_taken')->nullable();
            $table->decimal('total_amount', 8, 2);
            $table->enum('payment_status', ['Pending', 'Paid', 'Cancelled']);
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->softDeletes()->nullable();
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
