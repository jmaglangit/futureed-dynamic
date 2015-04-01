<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvatarAccessoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('avatar_accessories', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('code')->nullable();
            $table->bigInteger('avatar_code');
            $table->string('accessory_image', 256);
            $table->integer('points_to_unlock');
            $table->string('description', 256);
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
		Schema::drop('avatar_accessories');
	}

}
