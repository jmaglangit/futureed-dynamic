<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdatedHelpRequestAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE help_request_answers change area_id subject_area_id INTEGER NOT NULL;");
		DB::statement("ALTER TABLE help_request_answers change is_verified request_answer_status ENUM ('Pending', 'Accepted', 'Rejected') NOT NULL;");

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE help_request_answers change subject_area_id area_id INTEGER NOT NULL;");
		DB::statement("ALTER TABLE help_request_answers change request_answer_status is_verified INTEGER;");
	}

}
