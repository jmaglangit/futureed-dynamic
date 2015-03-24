<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolumeDiscountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('volume_discounts', function(Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('min_seats');
            $table->smallInteger('percentage');
            $table->enum('status', ['Enabled', 'Disabled']);
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
		Schema::drop('volume_discounts');
	}

}
