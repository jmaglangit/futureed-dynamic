<?php

use FutureEd\Models\Core\Avatar;
use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class AvatarsTableSeeder extends Seeder {


    public function run()
    {

        \DB::table('avatars')->truncate();
        \DB::table('avatars')->insert(
       [
            [
            'code' => '101',
            'gender' => 'Female',
            'avatar_image' => 'astronaut_female.png',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
             [
            'code' => '102',
            'gender' => 'Male',
            'avatar_image' => 'astronaut_male.png',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
             [
            'code' => '103',
            'gender' => 'Female',
            'avatar_image' => 'doctor_female.jpg',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
            [
            'code' => '104',
            'gender' => 'Male',
            'avatar_image' => 'doctor_male.png',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
            [
            'code' => '105',
            'gender' => 'Female',
            'avatar_image' => 'engineer_female.jpg',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
            [
            'code' => '106',
            'gender' => 'Male',
            'avatar_image' => 'engineer_male.jpg',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
            [
            'code' => '107',
            'gender' => 'Female',
            'avatar_image' => 'entrepreneur_female.jpg',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
            [
            'code' => '108',
            'gender' => 'Male',
            'avatar_image' => 'entrepreneur_male.jpg',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
            [
            'code' => '109',
            'gender' => 'Female',
            'avatar_image' => 'fireman_female.png',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
            [
            'code' => '110',
            'gender' => 'Male',
            'avatar_image' => 'fireman_male.png',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
            [
            'code' => '111',
            'gender' => 'Female',
            'avatar_image' => 'pilot_female.png',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
            [
            'code' => '112',
            'gender' => 'Male',
            'avatar_image' => 'pilot_male.png',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
            [
            'code' => '113',
            'gender' => 'Female',
            'avatar_image' => 'scientest_female.png',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
            [
            'code' => '114',
            'gender' => 'Male',
            'avatar_image' => 'scientest_male.png',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ],
            [
            'code' => '115',
            'gender' => 'Male',
            'avatar_image' => 'gamedeveloper_male.jpg',
            'points_to_unlock' => 50,
            'description' => 'sample ',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);



    }

}