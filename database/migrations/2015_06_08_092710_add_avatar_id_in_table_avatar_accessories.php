<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarIdInTableAvatarAccessories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('avatar_accessories', function(Blueprint $table) {

			$table->string('name',128)->nullable()->after('code');
			$table->bigInteger('avatar_id')->after('name');

			$table->dropColumn('avatar_code');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('avatar_accessories', function(Blueprint $table) {

			$table->dropColumn('avatar_id','name');

			$table->bigInteger('avatar_code');

		});
	}

}
