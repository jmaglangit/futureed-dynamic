<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class SchoolsTableSeeder extends Seeder {

    public function run()
    {

       \DB::table('schools')->truncate();
        \DB::table('schools')->insert([
            [
                'code' => 1,
                'name' => 'School of Minions',
                'street_address' => 'Left Street, Cor. Right One',
                'city' => 'Alpha City',
                'state' => 'Tasteless',
				'country_id' => 840,
                'country' => 'Lilipot',
                'zip' => 90210,
                'status' => 'Enabled',
                'contact_name' => 'Para Phe Dee',
                'contact_number' => '0987654321-0-1',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);
    }

}