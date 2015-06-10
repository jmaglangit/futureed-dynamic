<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class GradeTableSeeder extends Seeder {

    public function run()
    {
        \DB::table('grades')->truncate();
        \DB::table('grades')->insert([

			//United States of America
            [
                'name' => 'Grade 1',
                'description' => 'Grade One',
                'country_id' => config('futureed.default_country'),
                'code' =>1,
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
                'code' =>2,
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
                'code' =>3,
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
                'code' =>4,
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
                'code' =>5,
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
                'code' =>6,
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
                'code' =>7,
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
                'code' =>8,
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
			[
				'name' => 'Grade 9',
				'description' => 'Grade Nine',
				'country_id' => config('futureed.default_country'),
				'code' =>9,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'Grade 10',
				'description' => 'Grade Ten',
				'country_id' => config('futureed.default_country'),
				'code' =>10,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'Grade 11',
				'description' => 'Grade Elevent',
				'country_id' => config('futureed.default_country'),
				'code' =>11,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'Grade 12',
				'description' => 'Grade Twelve',
				'country_id' => config('futureed.default_country'),
				'code' =>12,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],

			//Singapore
			[
				'name' => 'Primary 1',
				'description' => 'Primary One',
				'country_id' => 702,
				'code' =>13,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'Primary 2',
				'description' => 'Primary Two',
				'country_id' => 702,
				'code' =>14,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'Primary 3',
				'description' => 'Primary Three',
				'country_id' =>702,
				'code' =>15,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'Primary 4',
				'description' => 'Primary Four',
				'country_id' => 702,
				'code' =>16,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'Primary 5',
				'description' => 'Primary Five',
				'country_id' => 702,
				'code' =>17,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'Primary 6',
				'description' => 'Primary Six',
				'country_id' => 702,
				'code' =>18,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'Sec 1',
				'description' => 'Sec One',
				'country_id' => 702,
				'code' =>19,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'Sec 2',
				'description' => 'Sec Two',
				'country_id' => 702,
				'code' =>20,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'Sec 3',
				'description' => 'Sec Three',
				'country_id' => 702,
				'code' =>21,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'Sec 4',
				'description' => 'Sec Four',
				'country_id' => 702,
				'code' =>22,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'JC 1',
				'description' => 'JC One',
				'country_id' => 702,
				'code' =>23,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
			[
				'name' => 'JC 2',
				'description' => 'JC Two',
				'country_id' => 702,
				'code' =>24,
				'status' => 'Enabled',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")

			],
        ]);
    }

}