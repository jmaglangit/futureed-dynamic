<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ModuleTableSeeder extends Seeder
{
    public function run()
    {
		\DB::table('modules')->truncate();
		\DB::table('modules')->insert([
			[
				'subject_id' => 1,
				'subject_area_id' => 1,
				'grade_id' => 1,
				'code' => 1,
				'name' => 'Math',
				'description' => 'Math Singapore',
				'status' => 'Enabled',
				'common_core_area' => 'Math',
				'common_core_url' => 'Math.com',
				'points_to_unlock' => 0,
				'points_to_finish' => 10,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'subject_id' => 1,
				'subject_area_id' => 1,
				'grade_id' => 1,
				'code' => 1,
				'name' => 'Science',
				'description' => 'Science Singapore',
				'status' => 'Enabled',
				'common_core_area' => 'Science',
				'common_core_url' => 'Science.com',
				'points_to_unlock' => 0,
				'points_to_finish' => 10,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'subject_id' => 1,
				'subject_area_id' => 1,
				'grade_id' => 1,
				'code' => 1,
				'name' => 'English',
				'description' => 'English Singapore',
				'status' => 'Enabled',
				'common_core_area' => 'English',
				'common_core_url' => 'English.com',
				'points_to_unlock' => 0,
				'points_to_finish' => 10,
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
		]);
	}
}

