<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('help_requests', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('class_id');
            $table->bigInteger('user_id');
            $table->string('title',128);
            $table->TEXT('content');
            $table->bigInteger('module_code');
            $table->bigInteger('subject_code');
            $table->bigInteger('area_code');
            $table->tinyInteger('is_verified')->nullable();
            $table->enum('status',['Enabled', 'Disabled']);
            $table->enum('question_status',['Open', 'Answered', 'Cancelled']);
            $table->timestamp('last_answered_at');
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
		Schema::drop('help_requests');
	}

}
