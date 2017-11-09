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

		$reader = Reader::createFromPath( storage_path('seeders') . '/avatar_wiki.csv');

		\DB::table('avatar_wikis')->truncate();
		foreach($reader as $index => $row){

			\DB::table('avatar_wikis')->insert([
				[
					'avatar_id' => $row[1],
					'code' => $row[2],
					'name' => $row[3],
					'description_full' => $row[4],
					'description_summary' => $row[5],
					'title' => $row[6],
					'source' => $row[7],
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);

		}

    }
}
