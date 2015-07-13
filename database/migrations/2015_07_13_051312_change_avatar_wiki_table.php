<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAvatarWikiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::table('avatar_wikis',function(Blueprint $table){
			$table->dropColumn(['description','event']);
		});

		Schema::table('avatar_wikis',function(Blueprint $table){

			$table->text('description_full')->after('name');
			$table->text('description_summary')->after('description_full');
			$table->text('title')->after('description_summary');
		});


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('avatar_wikis',function(Blueprint $table){

			$table->dropColumn(['description_full','description_summary','title']);
		});

		Schema::table('avatar_wikis', function(Blueprint $table){
			$table->string('description',256)->after('name');
			$table->string('event',128)->after('source');
		});



	}

}
