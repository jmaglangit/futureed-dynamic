<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class ClientTableSeeder extends Seeder {

    public function run()
    {
        // TestDummy::times(20)->create('App\Post');
        \DB::table('clients')->truncate();
        \DB::table('clients')->insert([
            [
                'user_id' => 2,
                'first_name' => 'Farrah Faye',
                'last_name' => 'Dy',
                'client_role' => 'Parent',
                'school_code' => 1,
                'street_address' => '',
                'city' => '',
                'state' => '',
                'country' => '',
                'zip' => 1234,
                'is_account_reviewed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 2,
                'first_name' => 'Farrah Faye',
                'last_name' => 'Dy',
                'client_role' => 'Principal',
                'school_code' => 1,
                'street_address' => '',
                'city' => '',
                'state' => '',
                'country' => '',
                'zip' => 5678,
                'is_account_reviewed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'user_id' => 2,
                'first_name' => 'Farrah Faye',
                'last_name' => 'Dy',
                'client_role' => 'Teacher',
                'school_code' => 1,
                'street_address' => '',
                'city' => '',
                'state' => '',
                'country' => '',
                'zip' => 9012,
                'is_account_reviewed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);

    }

}