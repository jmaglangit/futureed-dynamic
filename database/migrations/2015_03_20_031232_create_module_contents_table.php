<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('module_contents', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('module_code');
            $table->bigInteger('subject_code');
            $table->bigInteger('grade_code');
            $table->bigInteger('area_code');
            $table->bigInteger('content_code');
            $table->bigInteger('seq_no');
            $table->enum('status', ['Enabled', 'Disabled']);
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
		Schema::drop('module_contents');
	}

}
