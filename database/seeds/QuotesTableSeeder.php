<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class QuotesTableSeeder extends Seeder
{
//+---------------+-------------------------+------+-----+---------------------+----------------+
//| Field         | Type                    | Null | Key | Default             | Extra          |
//+---------------+-------------------------+------+-----+---------------------+----------------+
//| id            | int(10) unsigned        | NO   | PRI | NULL                | auto_increment |
//| quote         | text                    | NO   |     | NULL                |                |
//| percent       | smallint(6)             | NO   |     | NULL                |                |
//| answer_status | enum('Correct','Wrong') | NO   |     | NULL                |                |
//| seq_no        | bigint(20)              | NO   |     | NULL                |                |
//| created_by    | bigint(20)              | NO   |     | NULL                |                |
//| updated_by    | bigint(20)              | NO   |     | NULL                |                |
//| created_at    | timestamp               | NO   |     | 0000-00-00 00:00:00 |                |
//| updated_at    | timestamp               | NO   |     | 0000-00-00 00:00:00 |                |
//| deleted_at    | timestamp               | YES  |     | NULL                |                |
//+---------------+-------------------------+------+-----+---------------------+----------------+

	public function run()
    {
		\DB::table('quotes')->truncate();
		\DB::table('quotes')->insert([
			[
				'quote' => 'This is a challenging topic but you can do it',
				'percent' => '80',
				'answer_status' => 'Wrong',
				'seq_no' => '',
				'created_by' => '',
				'updated_by' => '',
				'created_at' => '',
				'updated_at' => ''
			]
		]);
    }
}
