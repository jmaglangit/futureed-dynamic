<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class SubjectTableSeeder extends Seeder
{
    public function run()
    {

		$seed = [
			[1,'Math','Singapore Math','Enabled'],
			[2,'English Grammar','US Common Core, Singapore English Grammar','Enabled'],
			[3,'English Vocabulary','US Common Core, Singapore English Vocabulary','Enabled'],
			[4,'Coding','Basic Visual Coding for Kids','Enabled'],
			[5,'Reading Comprehension','Reading Comprehension','Enabled'],
		];

		\DB::table('subjects')->truncate();

		foreach($seed as $data){

			\DB::table('subjects')->insert([
				[
					'code' => $data[0],
					'name' => $data[1],
					'description' => $data[2],
					'status' => $data[3],
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);
		}
    }
}
