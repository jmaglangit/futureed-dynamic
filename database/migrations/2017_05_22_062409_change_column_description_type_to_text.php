<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnDescriptionTypeToText extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE modules MODIFY COLUMN description TEXT");
        DB::statement("ALTER TABLE module_translations MODIFY COLUMN description TEXT");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE modules MODIFY COLUMN description TINYTEXT");
        DB::statement("ALTER TABLE module_translations MODIFY COLUMN description TINYTEXT");
    }

}
