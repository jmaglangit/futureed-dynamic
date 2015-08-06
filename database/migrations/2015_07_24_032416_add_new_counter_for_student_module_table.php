<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewCounterForStudentModuleTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_modules', function (Blueprint $table){
            $table->tinyInteger('current_difficulty_level')->after('last_answered_question_id');
            $table->tinyInteger('total_correct_answer')->after('last_answered_question_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_modules', function (Blueprint $table){
            $table->dropColumn('current_difficulty_level');
            $table->dropColumn('total_correct_answer');
        });
    }

}
