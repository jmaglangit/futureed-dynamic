<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSecurityLogTableColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE security_logs CHANGE  log_type log_type ENUM('User','Admin') ;");
		DB::statement("ALTER TABLE security_logs CHANGE  lod_id log_id INTEGER ;");

		Schema::table('security_logs', function(Blueprint $table){

			$table->dropColumn('proxy_ip');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE security_logs CHANGE  log_type log_type ENUM('User','Admin') NOT NULL ;");
		DB::statement("ALTER TABLE security_logs CHANGE  log_id lod_id NOT NULL ;");

		Schema::table('security_logs', function(Blueprint $table){

			$table->text('proxy_ip')->after('client_port');
		});
	}

}
