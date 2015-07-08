<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusOnTeachingContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('teaching_contents', function(Blueprint $table){

			$table->enum('status',['Enabled','Disabled'])->after('media_type_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('teaching_contents', function(Blueprint $table){

			$table->dropColumn('status');
		});
	}

}
