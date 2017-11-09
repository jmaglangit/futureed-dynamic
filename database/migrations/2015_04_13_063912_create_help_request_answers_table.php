<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpRequestAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('help_request_answers', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->TEXT('content');
            $table->bigInteger('help_request_id');
            $table->bigInteger('module_code');
            $table->bigInteger('subject_code');
            $table->bigInteger('area_code');
            $table->tinyInteger('rating')->nullable();
            $table->bigInteger('seq_no');
            $table->tinyInteger('is_verified')->nullable();
            $table->enum('status',['Enabled','Disabled']);
            $table->Integer('points')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes()->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('help_request_answers');
	}

}
