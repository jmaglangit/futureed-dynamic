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
                'code' => 101,
                'name' => 'K1',
                'description' => 'K One',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'code' => 102,
                'name' => 'K2',
                'description' => 'K Two',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'code' => 103,
                'name' => 'Grade 1',
                'description' => 'Grade One',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'code' => 104,
                'name' => 'Grade 2',
                'description' => 'Grade Two',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'code' => 105,
                'name' => 'Grade 3',
                'description' => 'Grade Three',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'code' => 106,
                'name' => 'Grade 4',
                'description' => 'Grade Four',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'code' => 107,
                'name' => 'Grade 5',
                'description' => 'Grade Five',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'code' => 108,
                'name' => 'Grade 6',
                'description' => 'Grade Six',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'code' => 109,
                'name' => 'Grade 7',
                'description' => 'Grade Seven',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],
            [
                'code' => 110,
                'name' => 'Grade 8',
                'description' => 'Grade Eight',
                'status' => 'Enabled',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")

            ],

        ]);
    }

}