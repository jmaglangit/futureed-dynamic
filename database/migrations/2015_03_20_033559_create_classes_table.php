<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classes', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('order_no');
            $table->bigInteger('name')->nullable();
            $table->bigInteger('grade_code');
            $table->bigInteger('client_id');
            $table->smallInteger('seats_taken');
            $table->smallInteger('seats_total');
            $table->enum('status', ['Enabled', 'Disabled']);
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamp('deleted_at');
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
		Schema::drop('classes');
	}

}
