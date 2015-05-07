<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_details', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoice_no');
            $table->bigInteger('class_id');
            $table->string('class_name',128);
            $table->bigInteger('grade_code');
            $table->smallInteger('seats_total');
            $table->decimal('sub_total',8,2);
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
		Schema::drop('invoice_details');
	}

}
