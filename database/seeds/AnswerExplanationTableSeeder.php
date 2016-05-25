<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

use Laracasts\TestDummy\Factory as TestDummy;
use League\Csv\Reader;

class AnswerExplanationTableSeeder extends Seeder
{
    public function run() {

        $reader = Reader::createFromPath(storage_path('seeders') . '/answer_explanations.csv');

        DB::table('answer_explanations')->truncate();

        foreach($reader as $data){

            DB::table('answer_explanations')->insert([
                'module_id' => $data[1],
                'question_id' => $data[2],
                'answer_id' => $data[3],
                'learning_style_id' => $data[4],
                'seq_no' => $data[5],
                'answer_explanation' => $data[6],
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        }

    }
}
