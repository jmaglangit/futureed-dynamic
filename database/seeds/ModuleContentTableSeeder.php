<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;
use League\Csv\Reader;

class ModuleContentTableSeeder extends Seeder
{
	public function run()
	{
		$reader = Reader::createFromPath('public/csv/module_content.csv');

		\DB::table('module_contents')->truncate();

		foreach ($reader as $index => $row) {

			\DB::table('module_contents')->insert([
				[
					'module_id' => $row[0],
					'subject_id' => $row[1],
					'subject_area_id' => $row[2],
					'content_id' => $row[3],
					'seq_no' => $row[4],
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);
		}
	}
}
