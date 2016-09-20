<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class QuestionAnswerTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('question_answers')->truncate();

		$this->dataLoader(['question_answers.csv', 'question_answers_two.csv']);

		$this->addTranslation();
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
					DB::table('question_answers')->insert([
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
							'translatable' => 1,
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

	/**
	 * Initialize translation for question answers
	 */
	public function addTranslation(){

		//truncate translation table
		DB::table('question_answer_translations')->truncate();

		//count records
		$question_answer_count = DB::table('question_answers')->count();

		$locales = config('translatable.locales');

		//loop through each language
		foreach($locales as $locale) {
			//initialize batch record.
			$limit = config('futureed.seeder_record_limit');
			$offset = 0;

			//command info
			$this->command->info('Initializing translation ' . ceil(($question_answer_count/$limit)) . ' batch of '
				. $question_answer_count . ' records.');

			//loop through each question answer record
			for($i=0;$i < ceil(($question_answer_count/$limit)); $i++){

				//get data by batch
				$question_answer = DB::table('question_answers')->select('id','answer_text')
					->skip($offset)->limit($limit)->get();

				//update offset
				$offset += $limit;

				$this->command->info('Inserting batch ' . ($i+1) . ' of '. (ceil(($question_answer_count/$limit))));

				//loop through each batch record
				$translation = [];
				foreach($question_answer as $answer => $ans){

					array_push($translation,[
						'question_answer_id' => $ans->id,
						'answer_text' => $ans->answer_text,
						'locale' => $locale,
						'created_by' => 1,
						'updated_by' => 1,
						'created_at' => Carbon::now(),
						'updated_at' => Carbon::now()
					]);
				}

				//insert batch record
				DB::table('question_answer_translations')->insert($translation);
			}
		}

	}
}
