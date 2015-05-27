<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class GradeTableSeeder extends Seeder {

    public function run()
    {
        \DB::table('grades')->truncate();
        \DB::table('grades')->insert([
            [
                'name' => 'K1',
                'description' => 'K One',
                'country_id' => config('futureed.default_country'),
                'code' =>101,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'name' => 'K2',
                'description' => 'K Two',
                'country_id' => config('futureed.default_country'),
                'code' =>102,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'name' => 'Grade 1',
                'description' => 'Grade One',
                'country_id' => config('futureed.default_country'),
                'code' =>103,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'name' => 'Grade 2',
                'description' => 'Grade Two',
                'country_id' => config('futureed.default_country'),
                'code' =>104,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'name' => 'Grade 3',
                'description' => 'Grade Three',
                'country_id' => config('futureed.default_country'),
                'code' =>105,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'name' => 'Grade 4',
                'description' => 'Grade Four',
                'country_id' => config('futureed.default_country'),
                'code' =>106,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'name' => 'Grade 5',
                'description' => 'Grade Five',
                'country_id' => config('futureed.default_country'),
                'code' =>107,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'name' => 'Grade 6',
                'description' => 'Grade Six',
                'country_id' => config('futureed.default_country'),
                'code' =>108,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'name' => 'Grade 7',
                'description' => 'Grade Seven',
                'country_id' => config('futureed.default_country'),
                'code' =>109,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'name' => 'Grade 8',
                'description' => 'Grade Eight',
                'country_id' => config('futureed.default_country'),
                'code' =>110,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],

        ]);
    }

}