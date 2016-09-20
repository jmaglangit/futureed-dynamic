<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddTranslatableColumnToAnswerExplanationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('answer_explanations',function(Blueprint $table){
			$table->integer('translatable')->after('answer_explanation');
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
			$table->dropColumn('translatable');
		});
	}

}
