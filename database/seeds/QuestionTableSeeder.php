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
					'questions_image' => $row[5],
					'original_image_name' => $row[5],
					'answer' => $row[6],
					'question_order_text' => $row[7],
					'question_graph_image' => $row[8],
					'seq_no' => $row[9],
					'difficulty' => ($row[10] == '')? 0 : $row[10],
					'points_earned' => $row[11],
					'status' => $row[12],
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);

		}

    }
}
