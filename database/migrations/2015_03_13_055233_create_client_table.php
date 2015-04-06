<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->enum('client_role', ['Parent', 'Principal', 'Teacher']);
            $table->bigInteger('school_code');
            $table->string('street_address', 128)->nullable();
            $table->string('city', 128)->nullable();
            $table->string('state', 128)->nullable();
            $table->string('country', 128)->nullable();
            $table->integer('zip')->nullable();
            $table->tinyInteger('is_account_reviewed');
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
		Schema::drop('client');
	}

}
