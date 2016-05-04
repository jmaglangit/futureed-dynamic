<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use League\Csv\Reader;

class QuestionAnswerTableSeeder extends Seeder
{
	public function run()
	{
		\DB::table('question_answers')->truncate();

		$this->dataLoader(['question_answers.csv', 'question_answers_two.csv']);
	}

	/**
	 * @param array $seeder_file must be a plain array
	 */
	private function dataLoader($seeder_file = [])
	{
		if(!empty($seeder_file))
		{
			foreach($seeder_file as $key => $value)
			{
				$this->command->info('Loading Question Answer Batch '.($key+1).'...');
				$this->command->info(storage_path('seeders') . '/'.$value);
				$reader = Reader::createFromPath( storage_path('seeders') . '/'.$value);
				foreach($reader as $index => $row)
				{
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
	}
}
