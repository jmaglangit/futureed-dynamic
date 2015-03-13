<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectAreasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subject_areas', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('subject_code');
            $table->bigInteger('code')->nullable();
            $table->string('name', 128)->nullable();
            $table->string('description', 256);
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
		Schema::drop('subject_areas');
	}

}
