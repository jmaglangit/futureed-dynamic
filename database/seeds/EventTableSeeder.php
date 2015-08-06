<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;

class EventTableSeeder extends Seeder
{
		public function run()
	{
		$seeder = [
			['1','Complete Module','Completion of the Modules','1','1'],
			['2','Complete Subject','Completion of all the Modules under the subject','1','1'],


		];


		\DB::table('events')->truncate();

		foreach($seeder as $data){

			DB::table('events')->insert([
				'code' => $data[0],
				'name' => $data[1],
				'description' => $data[2],
				'created_by' => $data[3],
				'updated_by' => $data[4],
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);
		}

	}

}
