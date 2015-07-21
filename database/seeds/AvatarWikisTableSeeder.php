<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use League\Csv\Reader;
use Carbon\Carbon;

class AvatarWikisTableSeeder extends Seeder
{
    public function run()
    {

		$reader = Reader::createFromPath('public/csv/avatar_wiki.csv');

		\DB::table('avatar_wikis')->truncate();
		foreach($reader as $index => $row){

			\DB::table('avatar_wikis')->insert([
				[
					'avatar_id' => $row[0],
					'code' => $row[1],
					'name' => $row[2],
					'description_full' => $row[3],
					'description_summary' => $row[4],
					'title' => $row[5],
					'source' => $row[6],
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);

		}

    }
}
