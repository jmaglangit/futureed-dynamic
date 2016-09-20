<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateQuoteTranslationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quote_translations',function(Blueprint $table){
			$table->increments('id');
			$table->integer('quote_id')->unsigned();
			$table->string('quote');
			$table->string('locale')->index();
			$table->bigInteger('created_by');
			$table->bigInteger('updated_by');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('quote_translations');
	}

}
