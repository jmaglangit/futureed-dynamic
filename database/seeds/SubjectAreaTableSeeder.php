<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;
use League\Csv\Reader;

class SubjectAreaTableSeeder extends Seeder
{
    public function run()
    {
        $seed = Reader::createFromPath( storage_path('seeders') . '/subject_areas.csv');

		\DB::table('subject_areas')->truncate();

		foreach($seed as $data){

			\DB::table('subject_areas')->insert([
				[
					'subject_id' => $data[1],
					'code' => $data[2],
					'name' => $data[3],
					'description' => $data[4],
					'status' => $data[5],
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);
		}
    }
}
