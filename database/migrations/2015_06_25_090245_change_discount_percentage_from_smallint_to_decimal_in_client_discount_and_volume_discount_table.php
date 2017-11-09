<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDiscountPercentageFromSmallintToDecimalInClientDiscountAndVolumeDiscountTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('client_discounts', function(Blueprint $table)
        {
            $table->dropColumn('percentage');
        });

        Schema::table('volume_discounts', function(Blueprint $table)
        {
            $table->dropColumn('percentage');
        });

        Schema::table('client_discounts', function(Blueprint $table)
        {
            $table->decimal('percentage',5,2)->after('client_id');
        });

        Schema::table('volume_discounts', function(Blueprint $table)
        {
            $table->decimal('percentage',5,2)->after('min_seats');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('client_discounts', function(Blueprint $table)
        {
            $table->dropColumn('percentage');
        });

        Schema::table('volume_discounts', function(Blueprint $table)
        {
            $table->dropColumn('percentage');
        });

        Schema::table('client_discounts', function(Blueprint $table)
        {
            $table->smallInteger('percentage')->after('client_id');
        });

        Schema::table('volume_discounts', function(Blueprint $table)
        {
            $table->smallInteger('percentage')->after('min_seats');
        });
	}

}
