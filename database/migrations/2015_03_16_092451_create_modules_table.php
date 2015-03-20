<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modules', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('subject_code');
            $table->bigInteger('area_code');
            $table->bigInteger('level_code');
            $table->bigInteger('code')->nullable();
            $table->string('name', 128)->nullable();
            $table->string('description', 256);
            $table->string('common_core_area', 256);
            $table->string('common_core_url', 256);
            $table->integer('points_to_unlock');
            $table->integer('points_to_finish');
            $table->enum('status', ['Enabled', 'Disabled']);
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
		Schema::drop('modules');
	}

}
