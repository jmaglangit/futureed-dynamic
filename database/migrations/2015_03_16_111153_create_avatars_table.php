<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvatarsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('avatars', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('code')->nullable();
            $table->enum('gender', ['Male', 'Female']);
            $table->string('avatar_image', 256);
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
		Schema::drop('avatars');
	}

}
