<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

use Laracasts\TestDummy\Factory as TestDummy;
use League\Csv\Reader;

class AnswerExplanationTableSeeder extends Seeder
{
    public function run() {

        DB::table('answer_explanations')->truncate();

        $this->dataLoader([
            'answer_explanations.csv',
            'answer_explanations_two.csv'
        ]);

    }

    /**
     * Data loader from csv to database.
     * @param array $data
     */
    public function dataLoader($data=[]){

        foreach($data as $k => $v){

            $this->command->info('Loading Answer Explanation batch file '. $v);
            $reader = Reader::createFromPath(storage_path('seeders') . '/' . $v);

            $seeds = [];

            foreach($reader as $data){

                array_push($seeds,[
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

            DB::table('answer_explanations')->insert($seeds);
        }
    }
}
