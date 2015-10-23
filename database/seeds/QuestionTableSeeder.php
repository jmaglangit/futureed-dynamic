<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Carbon\Carbon;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class QuestionTableSeeder extends Seeder
{
    public function run()
    {
//id,module_id,code,question_type,question_text,question_image,answer,seq_no,difficulty,points_earned,status
//,created_by,updated_by,created_by,updated_by,deleted_by


		$reader = Reader::createFromPath('public/csv/questions.csv');

		\DB::table('questions')->truncate();
		foreach($reader as $index => $row){

			\DB::table('questions')->insert([
				[
					'module_id' => $row[1],
					'code' => $row[2],
					'question_type' => $row[3],
					'questions_text' => $row[4],
					'original_image_name' => $row[6],
					'questions_image' => $row[6],
					'answer' => $row[7],
					'question_order_text' => $row[8],
					'question_graph_image' => $row[9],
					'seq_no' => $row[10],
					'difficulty' => ($row[11] == '')? 0 : $row[11],
					'points_earned' => ($row[12])? $row[12] : 0 ,
					'status' => ($row[13])? $row[13] : config('futureed.enabled'),
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);

		}

    }
}
