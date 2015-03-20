<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigIncrements('id');
            $table->string('username',128);
            $table->string('email',128);
            $table->string('new_email',128);
            $table->string('password',128);
            $table->string('name',128);
            $table->enum('user_type',['Admin','Client','Student']);
            $table->tinyInteger('login_attempt');
            $table->tinyInteger('is_account_activated');
            $table->tinyInteger('is_account_locked');
            $table->tinyInteger('is_account_deleted');
            $table->string('password_reset_token',256);
            $table->string('registration_verification_token',256);
            $table->string('remember_token',256);
            $table->string('change_email_token',256);
            $table->Timestamp('activated_at')->nullable();
            $table->string('timezone',64);
            $table->enum('status',['Enabled','Disabled']);
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
			$table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
