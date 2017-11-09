<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;

class AgeGroupTableSeeder extends Seeder
{
    public function run()
    {

		\DB::table('age_groups')->truncate();

//+------------+---------------------+------+-----+---------------------+----------------+
//| Field      | Type                | Null | Key | Default             | Extra          |
//	+------------+---------------------+------+-----+---------------------+----------------+
//| id         | bigint(20) unsigned | NO   | PRI | NULL                | auto_increment |
//| age        | tinyint(4)          | NO   |     | NULL                |                |
//| name       | varchar(255)        | YES  |     | NULL                |                |
//| created_by | bigint(20)          | NO   |     | NULL                |                |
//| updated_by | bigint(20)          | NO   |     | NULL                |                |
//| created_at | timestamp           | NO   |     | 0000-00-00 00:00:00 |                |
//| updated_at | timestamp           | NO   |     | 0000-00-00 00:00:00 |                |
//| deleted_at | timestamp           | YES  |     | NULL                |                |
//+------------+---------------------+------+-----+---------------------+----------------+
		$start_age = 7;
		for($i = 0 ; $i < 12 ; $i++){
			\DB::table('age_groups')->insert([
				[
					'age' => $start_age,
					'name' => 'Age '.$start_age ,
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);
			$start_age++;

		}
    }
}
