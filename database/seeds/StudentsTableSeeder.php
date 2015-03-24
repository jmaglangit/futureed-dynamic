<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class StudentsTableSeeder extends Seeder {

    public function run()
    {

        \DB::table('students')->truncate();
        try {
            \DB::table('students')->insert(
                [
                    [
                        'user_id' => 3,
                        'first_name' => 'Farrah',
                        'last_name' => 'Dy',
                        'gender' => 'Female',
                        'birth_date' => date("Y-m-d H:i:s"),
                        'avatar_id' => 1,
                        'password_image_id' => 1,
                        'school_code' => 1,
                        'grade_code' => 1,
                        'points' => 123,
                        'point_level_id' => 4,
                        'learning_style_id' => 1,
                        'status' => 'Enabled',
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ]
                ]);
        } catch(Exception $e){
            throw new Exception ($e->getMessage());
        }

    }

}