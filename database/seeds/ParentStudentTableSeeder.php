<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;

class ParentStudentTableSeeder extends Seeder
{
    public function run()
    {
		\DB::table('parent_students')->truncate();
		\DB::table('parent_students')->insert([
			[
				'parent_id' => 1,
				'student_id' => 1,
				'invitation_code' => 1234,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'parent_id' => 1,
				'student_id' => 2,
				'invitation_code' => 1234,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			],
			[
				'parent_id' => 1,
				'student_id' => 3,
				'invitation_code' => 1234,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			]
		]);
    }
}
