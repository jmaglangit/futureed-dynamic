<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;

class ClassroomTableSeeder extends Seeder
{
    public function run()
    {

//        +-------------+----------------------------+------+-----+---------------------+----------------+
//| Field       | Type                       | Null | Key | Default             | Extra          |
//    +-------------+----------------------------+------+-----+---------------------+----------------+
//| id          | bigint(20) unsigned        | NO   | PRI | NULL                | auto_increment |
//| order_no    | bigint(20)                 | NO   |     | NULL                |                |
//| name        | bigint(20)                 | YES  |     | NULL                |                |
//| grade_id    | bigint(20)                 | NO   |     | NULL                |                |
//| client_id   | bigint(20)                 | NO   |     | NULL                |                |
//| seats_taken | smallint(6)                | NO   |     | NULL                |                |
//| seats_total | smallint(6)                | NO   |     | NULL                |                |
//| status      | enum('Enabled','Disabled') | NO   |     | NULL                |                |
//| created_by  | bigint(20)                 | NO   |     | NULL                |                |
//| updated_by  | bigint(20)                 | NO   |     | NULL                |                |
//| deleted_at  | timestamp                  | YES  |     | NULL                |                |
//| created_at  | timestamp                  | NO   |     | 0000-00-00 00:00:00 |                |
//| updated_at  | timestamp                  | NO   |     | 0000-00-00 00:00:00 |                |
//+-------------+----------------------------+------+-----+---------------------+----------------+
        \DB::table('classrooms')->truncate();
        \DB::table('classrooms')->insert([
            [
                'order_no' => 1,
                'name' => 'Panic Room',
                'grade_id' => 3,
                'client_id' => 1,
                'seats_taken' => 3,
                'seats_total' => 3,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'order_no' => 1,
                'name' => 'Alpha Room',
                'grade_id' => 3,
                'client_id' => 1,
                'seats_taken' => 3,
                'seats_total' => 3,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'order_no' => 1,
                'name' => 'Beta Room',
                'grade_id' => 3,
                'client_id' => 1,
                'seats_taken' => 3,
                'seats_total' => 3,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'order_no' => 2,
                'name' => 'Charlie Room',
                'grade_id' => 3,
                'client_id' => 1,
                'seats_taken' => 3,
                'seats_total' => 3,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'order_no' => 2,
                'name' => 'Delta Room',
                'grade_id' => 3,
                'client_id' => 1,
                'seats_taken' => 3,
                'seats_total' => 3,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'order_no' => 2,
                'name' => 'Foxtrot Room',
                'grade_id' => 3,
                'client_id' => 1,
                'seats_taken' => 3,
                'seats_total' => 3,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'order_no' => 3,
                'name' => 'Gamma Room',
                'grade_id' => 3,
                'client_id' => 1,
                'seats_taken' => 3,
                'seats_total' => 3,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'order_no' => 3,
                'name' => 'Hector Room',
                'grade_id' => 3,
                'client_id' => 1,
                'seats_taken' => 3,
                'seats_total' => 3,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]

        ]);

    }
}
