<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvatarQuotesTable extends Migration {
//No	Field Name	Screen Label	Data Type	Length	Required
//1	id	 	BIGINT	20	Yes
//2	avatar_pose_id	[internal field]	BIGINT	20	Yes
//3	quote_id	[internal field]	BIGINT	20	Yes
//4	created_by	Created By	BIGINT	20	Yes
//5	updated_by	Updated By	BIGINT	20	Yes
//6	created_at	Created Date	TIMESTAMP		Yes
//7	updated_at	Updated Date	TIMESTAMP		Yes
//8	deleted_at	[internal field]	TIMESTAMP		Yes
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('avatar_quotes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('avatar_pose_id');
			$table->bigInteger('quote_id');
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
		Schema::drop('avatar_quotes');
	}

}
