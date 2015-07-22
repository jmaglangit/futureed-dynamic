<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarIdInAvatarQuotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('avatar_quotes', function (Blueprint $table){
            $table->bigInteger('avatar_id')->after('id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('avatar_quotes', function (Blueprint $table){
            $table->dropColumn('avatar_id');
        });
	}

}
