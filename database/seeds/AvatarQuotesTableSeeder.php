<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use League\Csv\Reader;

class AvatarQuotesTableSeeder extends Seeder
{

	public function run()
	{
		$reader = Reader::createFromPath('public/csv/avatar_quotes.csv');

		DB::table('avatar_quotes')->truncate();

		foreach($reader as $data){

			DB::table('avatar_quotes')->insert([
				'id' => $data[0],
				'avatar_id' => $data[1],
				'avatar_pose_id' => $data[2],
				'quote_id' => $data[3],
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);

		}
	}
}
