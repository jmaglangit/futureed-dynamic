<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvatarWikisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('avatar_wikis', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('avatar_code');
            $table->bigInteger('code')->nullable();
            $table->string('name', 128)->nullable();
            $table->string('description', 256);
            $table->string('source', 256);
            $table->string('event', 128);
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamp('deleted_at');
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
		Schema::drop('avatar_wikis');
	}

}
