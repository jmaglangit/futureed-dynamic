<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLsPercentileToStudentLsScores extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('student_ls_scores', function(Blueprint $table)
		{
			$table->decimal('ls_percentile', 5, 2)->after('ls_std_score')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('student_ls_scores', function(Blueprint $table)
		{
			$table->dropColumn('ls_percentile');
		});
	}

}
