<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use League\Csv\Reader;

class QuestionAnswerTableSeeder extends Seeder
{
	public function run()
	{
		$reader = Reader::createFromPath( storage_path('seeders') . '/question_answers.csv');

		\DB::table('question_answers')->truncate();


		foreach($reader as $index => $row){

			\DB::table('question_answers')->insert([
				[
					'module_id' => $row[1],
					'question_id' => $row[2],
					'code' => $row[3],
					'label' => $row[4],
					'answer_text' => $row[5],
					'answer_image' => $row[6],
					'original_image_name' => $row[6],
					'correct_answer' => ($row['7']=='N' ? 'No' : 'Yes'),
					'point_equivalent' => $row[8],
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);

		}

	}
}
