<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class AnswerExplanationTableSeeder extends Seeder
{
    public function run() {

        DB::table('answer_explanations')->truncate();

        $this->dataLoader([
            'answer_explanations.csv',
            'answer_explanations_two.csv',
            'answer_explanations_three.csv'
        ]);

        //initialize translation
        $this->addTranslation();
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

    /**
     * Initialize translation for answer explanation.
     */
    public function addTranslation(){

        //count records
        $answer_count = DB::table('answer_explanations')->count();

        $this->command->info('Initializing translation ' . ceil(($answer_count/1000)) . ' batch of ' . $answer_count . ' records.');

        //initialize batch record.
        $limit = config('futureed.seeder_record_limit');
        $offset = 0;

        // truncate translation
        DB::table('answer_explanation_translations')->truncate();

        //loop through answer_explanation each record.
        for($i=0;$i < ceil(($answer_count/$limit)); $i++){

            //get data by batch
            $answer_data = DB::table('answer_explanations')->select('id','answer_explanation')
                ->skip($offset)->limit($limit)->get();

            $offset += $limit;

            $this->command->info('Inserting batch ' . ($i+1) . ' of '. (ceil(($answer_count/$limit))));

            //loop through each batch record
            $translation = [];
            foreach($answer_data as $answer => $ans){

                array_push($translation,[
                    'answer_explanation_id' => $ans->id,
                    'answer_explanation' => $ans->answer_explanation,
                    'locale' => 'en',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            //insert batch record.
            DB::table('answer_explanation_translations')->insert($translation);
        }
    }
}
