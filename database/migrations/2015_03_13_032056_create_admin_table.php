<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin', function(Blueprint $table) {
            $table->bigInteger('id',20);
            $table->bigInteger('user_id');
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->enum('admin_role', ['Admin', 'Super Admin']);
            $table->enum('status', ['Enabled', 'Disabled']);
            $table->bigInteger('created_by_id');
            $table->bigInteger('updated_by_id');
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
		Schema::drop('admin');
	}

}
