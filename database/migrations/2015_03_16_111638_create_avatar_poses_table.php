<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvatarPosesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('avatar_poses', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('avatar_code');
            $table->bigInteger('avatar_code');
            $table->bigInteger('code')->nullable();
            $table->string('name', 128)->nullable();
            $table->string('pose_image', 256);
            $table->string('description', 256);
            $table->bigInteger('created_by_id');
            $table->bigInteger('updated_by_id');
            $table->timestamp('delete_at');
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
		Schema::drop('avatar_poses');
	}

}
