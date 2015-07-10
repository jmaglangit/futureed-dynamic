<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotesTable extends Migration {
//No	Field Name	Screen Label	Data Type	Length	Required	Values	Sample Data
//1	id	 	BIGINT	20	Yes		1
//2	quote	Quote	TEXT		Yes		3 month Subscription
//3	percent	Percent	SMALLINT	3	Yes
//4	answer_status	[internal field]	ENUM			Correct, Wrong
//5	seq_no	Sequence No	BIGINT	20	Yes		1
//6	created_by	Created By	BIGINT	20	Yes		1
//7	updated_by	Updated By	BIGINT	20	Yes		1
//8	created_at	Created Date	TIMESTAMP		Yes		20150330 09:00:00
//9	updated_at	Updated Date	TIMESTAMP		Yes		20150330 09:01:00
//10	deleted_at	[internal field]	TIMESTAMP		Yes		00000000 00:00:00
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quotes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('quote');
			$table->smallInteger('percent');
			$table->enum('answer_status',['Correct','Wrong']);
			$table->bigInteger('seq_no');
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
		Schema::drop('quotes');
	}

}
