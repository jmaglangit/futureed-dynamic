<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToLearningStylesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('learning_styles', function(Blueprint $table)
		{
			$table->string('ls_banding', 256)->nullable()->after('id');
			$table->string('ls_ips_abbr', 2)->nullable()->after('ls_banding');
			$table->string('ls_ips_name', 32)->nullable()->after('ls_ips_abbr');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('learning_styles', function(Blueprint $table)
		{
			$table->dropColumn(['ls_banding', 'ls_ips_abbr', 'ls_ips_name']);
		});
	}

}
