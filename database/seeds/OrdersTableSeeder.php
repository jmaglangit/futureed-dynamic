<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
//        id              | bigint(20) unsigned                | NO   | PRI | NULL                | auto_increment |
////| order_no        | bigint(20)                         | NO   |     | NULL                |                |
////| order_date      | timestamp                          | NO   |     | 0000-00-00 00:00:00 |                |
////| client_id       | bigint(20)                         | NO   |     | NULL                |                |
////| subscription_id | bigint(20)                         | NO   |     | NULL                |                |
////| date_start      | timestamp                          | NO   |     | 0000-00-00 00:00:00 |                |
////| date_end        | timestamp                          | NO   |     | 0000-00-00 00:00:00 |                |
////| seats_total     | smallint(6)                        | NO   |     | NULL                |                |
////| seats_taken     | smallint(6)                        | YES  |     | NULL                |                |
////| total_amount    | decimal(8,2)                       | NO   |     | NULL                |                |
////| payment_status  | enum('Pending','Paid','Cancelled') | NO   |     | NULL                |                |
////| created_by      | bigint(20)                         | NO   |     | NULL                |                |
////| updated_by      | bigint(20)                         | NO   |     | NULL                |                |
////| deleted_at      | timestamp                          | YES  |     | NULL                |                |
////| created_at      | timestamp                          | NO   |     | 0000-00-00 00:00:00 |                |
//| updated_at      | timestamp                          | NO   |     | 0000-00-00 00:00:00 |
        \DB::table('orders')->truncate();
        \DB::table('orders')->insert([
            [
                'order_no' => 1,
                'order_date' => Carbon::now(),
                'client_id' => 1,
                'subscription_id' => 1,
                'date_start' => Carbon::now(),
                'date_end' => Carbon::now()->addDays(5),
                'seats_total' => 5,
                'seats_taken' => 3,
                'total_amount' => 999.99,
                'payment_status' => 'Paid',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_no' => 2,
                'order_date' => Carbon::now(),
                'client_id' => 2,
                'subscription_id' => 2,
                'date_start' => Carbon::now()->addDays(6),
                'date_end' => Carbon::now()->addDays(10),
                'seats_total' => 10,
                'seats_taken' => 7,
                'total_amount' => 1999.99,
                'payment_status' => 'Pending',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_no' => 3,
                'order_date' => Carbon::now(),
                'client_id' => 3,
                'subscription_id' => 3,
                'date_start' => Carbon::now()->addDays(11),
                'date_end' => Carbon::now()->addDays(16),
                'seats_total' => 15,
                'seats_taken' => 5,
                'total_amount' => 2999.99,
                'payment_status' => 'Cancelled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]

        ]);

    }
}
