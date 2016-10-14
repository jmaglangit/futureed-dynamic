<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Carbon\Carbon;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Illuminate\Support\Facades\Storage;

class QuestionTableSeeder extends Seeder
{
    public function run()
    {

		//id,module_id,code,question_type,questions_text,questions_image,original_image_name,answer,
		//question_order_text,question_graph_content,seq_no,difficulty,points_earned,translatable,
		//status,created_by,updated_by,deleted_at,created_at,updated_at

		DB::table('questions')->truncate();

		$this->command->info('Loading Question data...');
		$this->dataLoader('questions_1.csv');

		$this->command->info('Loading Question data...');
		$this->dataLoader('questions_2.csv');

		$this->command->info('Loading Question data...');
		$this->dataLoader('questions_3.csv');

		$this->addTranslation();
    }

	/**
	 * @param $seeder_csv_file
	 */
	public function dataLoader($seeder_csv_file){

		$this->command->info(storage_path('seeders') . '/' . $seeder_csv_file);
		$reader = Reader::createFromPath(storage_path('seeders') . '/' . $seeder_csv_file);

		foreach($reader as $index => $row){

			DB::table('questions')->insert([
				[
					'module_id' => $row[1],
					'code' => $row[2],
					'question_type' => $row[3],
					'questions_text' => $row[4],
					'questions_image' => $row[5],
					'original_image_name' => $row[6],
					'answer' => $row[7],
					'question_order_text' => $row[8],
					'question_graph_content' => $row[9],
					'seq_no' => $row[10],
					'difficulty' => $row[11],
					'points_earned' => $row[12],
					'translatable' => 1,
					'status' => $row[14],
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);

		}
	}

	/**
	 * Initialize translation for questions.
	 */
	public function addTranslation(){

		//truncate translation table
		DB::table('question_translations')->truncate();

		//count records
		$question_count = DB::table('questions')->count();

		$locales = config('translatable.locales');
		//loop through each locale
		foreach($locales as $locale){
			//initialize batch record
			$limit = config('futureed.seeder_record_limit');
			$offset = 0;

			//command info
			$this->command->info('Initializing '.strtoupper($locale).' translation ' . ceil(($question_count/$limit)) . ' batch of '
				. $question_count . ' records.');

			//loop through each question record
			for($i=0;$i < ceil(($question_count/$limit)); $i++) {

				//get record by batch
				$questions = DB::table('questions')->select('id','questions_text','answer')
					->skip($offset)->limit($limit)->get();

				//update offset
				$offset += $limit;

				$this->command->info('Inserting batch ' . ($i+1) . ' of '. (ceil(($question_count/$limit))));

				//loop through each command
				$translation = [];
				foreach($questions as $question => $q){

					array_push($translation,[
						'question_id' => $q->id,
						'questions_text' => $q->questions_text,
						'answer' => $q->answer,
						'locale' => $locale,
						'created_by' => 1,
						'updated_by' => 1,
						'created_at' => Carbon::now(),
						'updated_at' => Carbon::now()
					]);
				}

				//insert batch record
				DB::table('question_translations')->insert($translation);

			}
		}

	}
}
