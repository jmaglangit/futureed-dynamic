<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateDataLibraryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data_library',function(Blueprint $table){
			$table->bigIncrements('id');
			$table->enum('object_type',['NAME','THING']);
			$table->string('object_name',255);
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
		Schema::drop('data_library');
	}

}
