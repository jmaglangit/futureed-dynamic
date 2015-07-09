<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemSettingsTable extends Migration {
//No	Field Name	Screen Label	Data Type	Length	Required	Values	Sample Data
//1	id	 	BIGINT	20	Yes		1
//2	key	Key	VARCHAR	256
//3	value	Value	VARCHAR	256
//4	description	Description	VARCHAR	256			This is a sample description
//5	created_by	Created By	BIGINT	20	Yes		1
//6	updated_by	Updated By	BIGINT	20	Yes		1
//7	created_at	Created Date	TIMESTAMP		Yes		20150330 09:00:00
//8	updated_at	Updated Date	TIMESTAMP		Yes		20150330 09:01:00
//9	deleted_at	[internal field]	TIMESTAMP		Yes		00000000 00:00:00
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('system_settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('key');
			$table->string('value');
			$table->string('description')->nullable();
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
		Schema::drop('system_settings');
	}

}
