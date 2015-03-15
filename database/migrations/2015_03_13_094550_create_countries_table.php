<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countries', function(Blueprint $table) {
            $table->increments('id');
            $table->string('country_code', 8);
            $table->string('name', 128);
            $table->string('full_name', 256);
            $table->string('capital', 128);
            $table->string('citizenship', 256);
            $table->string('currency', 256);
            $table->string('currency_code', 256);
            $table->string('currency_sub_unit', 256);
            $table->string('iso_3166_2', 2);
            $table->string('iso_3166_3', 4);
            $table->string('region_code', 4);
            $table->string('sub_region_code', 4);
            $table->tinyInteger('eea');
            $table->bigInteger('created_by_id');
            $table->bigInteger('updated_by_id');
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
		Schema::drop('countries');
	}

}
