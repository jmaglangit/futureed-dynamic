<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageColumnToAnswerExplanationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('answer_explanations',function(Blueprint $table){
			$table->string('image', 256)->after('answer_explanation');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('answer_explanations',function(Blueprint $table){
			$table->dropColumn('image');
		});
	}

}
