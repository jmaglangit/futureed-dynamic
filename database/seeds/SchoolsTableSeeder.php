<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class SchoolsTableSeeder extends Seeder {

    public function run()
    {

       \DB::table('schools')->delete();
        \DB::table('schools')->insert([
            [
                'code' => 1,
                'name' => 'School of Minions',
                'street_address' => 'Left Street, Cor. Right One',
                'city' => 'Alpha City',
                'state' => 'Tasteless',
                'country' => 'Lilipot',
                'zip' => 90210,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);
    }

}