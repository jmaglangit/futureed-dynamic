<?php

use FutureEd\Models\Core\Avatar;
use Illuminate\Database\Seeder;
use Carbon\Carbon;



class AvatarsTableSeeder extends Seeder {


    public function run()
    {
        $i = 0;

        \DB::table('avatars')->truncate();
        \DB::table('avatars')->insert(
            [
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Female',
					'avatar_image' => 'astronaut-female/astronaut_female_1_main.png',
					'background_image' => 'background_image/mars-final-1.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Male',
					'avatar_image' => 'astronaut-male/astronaut_male_4_main.png',
					'background_image' => 'background_image/mars-final-1.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Female',
					'avatar_image' => 'doctor-female/doctor_female_5_main.png',
					'background_image' => 'background_image/operating-room-2.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Male',
					'avatar_image' => 'doctor-male/doctor_male-2_main.png',
					'background_image' => 'background_image/operating-room-2.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Female',
					'avatar_image' => 'engineer-female/engineer_female_7_main.png',
					'background_image' => 'background_image/construction-4-final.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Male',
					'avatar_image' => 'engineer-male/engineer_male_9_main.png',
					'background_image' => 'background_image/construction-4-final.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Female',
					'avatar_image' => 'entrepreneur-female/entrepreneur_female_8_main.png',
					'background_image' => 'background_image/office-interior-2.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Male',
					'avatar_image' => 'entrepreneur-male/entrepreneur_male_3_main.png',
					'background_image' => 'background_image/office-interior-2.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Male',
					'avatar_image' => 'fireman/fireman_8_main.png',
					'background_image' => 'background_image/burning-building.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Female',
					'avatar_image' => 'firewoman/firewoman_6_main.png',
					'background_image' => 'background_image/burning-building.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Female',
					'avatar_image' => 'nurse-female/nurse_1_main.png',
					'background_image' => 'background_image/operating-room-2.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Female',
					'avatar_image' => 'pilot-female/pilot_female_1_main.png',
					'background_image' => 'background_image/airport-1.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Male',
					'avatar_image' => 'pilot-male/pilot_male_1_main.png',
					'background_image' => 'background_image/airport-1.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Female',
					'avatar_image' => 'scientist-female/scientist_female_2_main.png',
					'background_image' => 'background_image/science-room-2.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Male',
					'avatar_image' => 'scientist-male/scientist_male_1_main.png',
					'background_image' => 'background_image/science-room-2.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Female',
					'avatar_image' => 'teacher-female/teacher_female_7_main.png',
					'background_image' => 'background_image/classroom-2.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],
				[
					'code' => Carbon::now()->addMinute($i++)->timestamp,
					'gender' => 'Male',
					'avatar_image' => 'teacher-male/teacher_male_6_main.png',
					'background_image' => 'background_image/classroom-2.jpg',
					'points_to_unlock' => 50,
					'description' => 'sample ',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				],


            ]);
    }

}