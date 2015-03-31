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
            $table->string('new_email',128)->nullable();
            $table->string('password',128);
            $table->string('name',128);
            $table->enum('user_type',['Admin','Client','Student']);
            $table->bigInteger('code')->nullable();
            $table->timestamp('code_expiry')->nullable();
            $table->tinyInteger('login_attempt')->nullable();
            $table->bigInteger('confirmation_code')->nullable();
            $table->timestamp('confirmation_code_expiry')->nullable();
            $table->bigInteger('reset_code')->nullable();
            $table->timestamp('reset_code_expiry')->nullable();
            $table->tinyInteger('is_link_to_parent')->nullable();
            $table->tinyInteger('is_account_activated')->nullable();
            $table->tinyInteger('is_account_locked')->nullable();
            $table->tinyInteger('is_account_deleted')->nullable();
            $table->string('password_reset_token',256)->nullable();
            $table->string('registration_verification_token',256)->nullable();
            $table->rememberToken();
            $table->string('change_email_token',256)->nullable();
            $table->Timestamp('activated_at')->nullable();
            $table->string('timezone',64)->nullable();
            $table->enum('status',['Enabled','Disabled']);
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
		Schema::drop('users');
	}

}
