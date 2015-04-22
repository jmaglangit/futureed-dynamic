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
                        'birth_date' => \Carbon\Carbon::now()->subYears(10),
                        'avatar_id' => 1,
                        'password_image_id' => 1,
                        'parent_id' => 1,
                        'school_code' => 1,
                        'grade_code' => 101,
                        'points' => 123,
                        'point_level_id' => 4,
                        'learning_style_id' => 1,
                        'status' => 'Enabled',
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ],
                    [
                        'user_id' => 6,
                        'first_name' => 'John Rey',
                        'last_name' => 'Quiros',
                        'gender' => 'Male',
                        'birth_date' => \Carbon\Carbon::now()->subYears(11),
                        'avatar_id' => 2,
                        'password_image_id' => 2,
                        'parent_id' => 2,
                        'school_code' => 1,
                        'grade_code' => 102,
                        'points' => 456,
                        'point_level_id' => 4,
                        'learning_style_id' => 1,
                        'status' => 'Enabled',
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ],
                    [
                        'user_id' => 9,
                        'first_name' => 'Jason',
                        'last_name' => 'Maglangit',
                        'gender' => 'Male',
                        'birth_date' => \Carbon\Carbon::now()->subYears(12),
                        'avatar_id' => 3,
                        'password_image_id' => 3,
                        'parent_id' => 2,
                        'school_code' => 1,
                        'grade_code' => 103,
                        'points' => 789,
                        'point_level_id' => 4,
                        'learning_style_id' => 1,
                        'status' => 'Enabled',
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ],
                    [
                        'user_id' => 12,
                        'first_name' => 'Jollie Mar',
                        'last_name' => 'Gutang',
                        'gender' => 'Male',
                        'birth_date' => \Carbon\Carbon::now()->subYears(13),
                        'avatar_id' => 4,
                        'password_image_id' => 3,
                        'parent_id' => 2,
                        'school_code' => 1,
                        'grade_code' => 103,
                        'points' => 123,
                        'point_level_id' => 4,
                        'learning_style_id' => 1,
                        'status' => 'Enabled',
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ],
                    [
                        'user_id' => 15,
                        'first_name' => 'Brian',
                        'last_name' => 'Monsales',
                        'gender' => 'Male',
                        'birth_date' => \Carbon\Carbon::now()->subYears(14),
                        'avatar_id' => 4,
                        'password_image_id' => 3,
                        'parent_id' => 2,
                        'school_code' => 1,
                        'grade_code' => 103,
                        'points' => 456,
                        'point_level_id' => 4,
                        'learning_style_id' => 1,
                        'status' => 'Enabled',
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    ],
                    [
                        'user_id' => 18,
                        'first_name' => 'Vince',
                        'last_name' => 'Gunday',
                        'gender' => 'Male',
                        'birth_date' => \Carbon\Carbon::now()->subYears(15),
                        'avatar_id' => 4,
                        'password_image_id' => 3,
                        'parent_id' => 2,
                        'school_code' => 1,
                        'grade_code' => 103,
                        'points' => 789,
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