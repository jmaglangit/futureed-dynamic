<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateQuestionCacheLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_cache_log', function(Blueprint $table){
			$table->bigIncrements('id');
			$table->integer('user_id');
			$table->text('description');
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
		Schema::drop('question_cache_log');
	}

}
