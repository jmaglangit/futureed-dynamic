<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuotesTableSeeder extends Seeder
{

	public function run()
	{
		$seeds = [
			[
				'quote' => 'This is a challenging topic but you can do it',
				'percent' => '20',
				'answer_status' => 'Correct',
				'seq_no' => '1',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'Do not give up! I know this is a little tough and will take more work. Keep going',
				'percent' => '20',
				'answer_status' => 'Correct',
				'seq_no' => '2',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'As you learn mistakes are expected. Just keep going, you will master it',
				'percent' => '20',
				'answer_status' => 'Correct',
				'seq_no' => '3',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'You have succeeded before with hard work, lets do it again',
				'percent' => '20',
				'answer_status' => 'Correct',
				'seq_no' => '4',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'This is difficult now but once you master this content you will grow',
				'percent' => '20',
				'answer_status' => 'Correct',
				'seq_no' => '5',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'So you did not do as well as you want, look at this as a learning opportunity',
				'percent' => '20',
				'answer_status' => 'Correct',
				'seq_no' => '6',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'I want you to stretch beyond your comfort zone and master this material',
				'percent' => '40',
				'answer_status' => 'Correct',
				'seq_no' => '1',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'Today I want you to challenge yourself, stretch and learn, grow',
				'percent' => '40',
				'answer_status' => 'Correct',
				'seq_no' => '2',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'Push yourself and master this content',
				'percent' => '40',
				'answer_status' => 'Correct',
				'seq_no' => '3',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'Mistakes are the path to learning and growing, do not be afraid',
				'percent' => '40',
				'answer_status' => 'Correct',
				'seq_no' => '4',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'Today your brain will get stronger as you continue to learn',
				'percent' => '40',
				'answer_status' => 'Correct',
				'seq_no' => '5',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'This is tough material but you can do it',
				'percent' => '40',
				'answer_status' => 'Correct',
				'seq_no' => '6',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'You should be proud of the effort you put into this, it shows',
				'percent' => '60',
				'answer_status' => 'Correct',
				'seq_no' => '1',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'I appreciate your hard work, it will pay off',
				'percent' => '60',
				'answer_status' => 'Correct',
				'seq_no' => '2',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'You are persistent and it shows',
				'percent' => '60',
				'answer_status' => 'Correct',
				'seq_no' => '3',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'I can see the progress that you are making, nice!',
				'percent' => '60',
				'answer_status' => 'Correct',
				'seq_no' => '4',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'Your hard work is paying off',
				'percent' => '60',
				'answer_status' => 'Correct',
				'seq_no' => '5',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'I can see that you are learning and enjoying it, keep going',
				'percent' => '80',
				'answer_status' => 'Correct',
				'seq_no' => '1',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'All your hard work and persistence paid off',
				'percent' => '80',
				'answer_status' => 'Correct',
				'seq_no' => '2',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'It is exciting to see you mastering this topic',
				'percent' => '80',
				'answer_status' => 'Correct',
				'seq_no' => '3',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'Look how far you have come',
				'percent' => '80',
				'answer_status' => 'Correct',
				'seq_no' => '4',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'You have mastered this topic. Now lets think of way to keep on growing your knowledge',
				'percent' => '100',
				'answer_status' => 'Correct',
				'seq_no' => '1',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'You are ready for something more challenging',
				'percent' => '100',
				'answer_status' => 'Correct',
				'translatable' => 1,
				'seq_no' => '2',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'This is a challenging topic but you can do it',
				'percent' => '0',
				'answer_status' => 'Correct',
				'seq_no' => '1',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'Do not give up! I know this is a little tough and will take more work. Keep going',
				'percent' => '0',
				'answer_status' => 'Correct',
				'seq_no' => '2',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'As you learn mistakes are expected. Just keep going, you will master it',
				'percent' => '0',
				'answer_status' => 'Correct',
				'seq_no' => '3',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'You have succeeded before with hard work, lets do it again',
				'percent' => '0',
				'answer_status' => 'Correct',
				'seq_no' => '4',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'This is difficult now but once you master this content you will grow',
				'percent' => '0',
				'answer_status' => 'Correct',
				'seq_no' => '5',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'quote' => 'So you did not do as well as you want, look at this as a learning opportunity',
				'percent' => '0',
				'answer_status' => 'Correct',
				'seq_no' => '6',
				'translatable' => 1,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]

		];

		// clear and insert quotes data.
		DB::table('quotes')->truncate();
		DB::table('quotes')->insert($seeds);

		//initialize translations.
		$this->addTranslation();

	}

	/**
	 * Initialize translations for quote.
	 */
	public function addTranslation(){

		DB::table('quote_translations')->truncate();

		$locales = config('translatable.locales');
		//loop throughout the languages
		foreach($locales as $locale){
			//loop throughout the quote table.
			$quotes = DB::table('quotes')->select('id','quote')->get();

			$translation = [];
			foreach($quotes as $quote => $q){

				array_push($translation,[
					'quote_id' => $q->id,
					'quote' => $q->quote,
					'locale' => $locale,
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]);
			}

			//clear and insert quotes data
			DB::table('quote_translations')->insert($translation);
		}

	}
}
