<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateModuleTranslationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('module_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('module_id')->unsigned();
			$table->string('name');
			$table->string('locale')->index();
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
		Schema::drop('module_translations');
	}

}
