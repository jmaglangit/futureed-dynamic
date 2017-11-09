<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropIsVerifiedFieldAndAddRequestStatusInHelpRequestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('help_requests', function(Blueprint $table){
            $table->dropColumn('is_verified');
            $table->enum('request_status',['Pending', 'Accepted', 'Rejected'])->after('link_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('help_requests', function(Blueprint $table){
            $table->tinyInteger('is_verified')->nullable()->after('link_id');
            $table->dropColumn('request_status');
        });
	}

}
