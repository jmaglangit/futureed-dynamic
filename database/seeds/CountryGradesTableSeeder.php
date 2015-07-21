<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;

class CountryGradesTableSeeder extends Seeder
{
    public function run()
    {
		\DB::table('country_grades')->truncate();

		//US
		$start_age = 1;
		$grade_id = 1;
		for($i = 0; $i < 12 ; $i++){

			\DB::table('country_grades')->insert([
				[
					'age_group_id' => $start_age,
					'country_id' => 840,
					'grade_id' => $grade_id,
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);
			$start_age++;
			$grade_id++;
		}

		//SG
		$start_age = 1;

		for($i = 0; $i < 12 ; $i++){

			\DB::table('country_grades')->insert([
				[
					'age_group_id' => $start_age,
					'country_id' => 702,
					'grade_id' => $grade_id,
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);
			$start_age++;
			$grade_id++;
		}
    }
}
