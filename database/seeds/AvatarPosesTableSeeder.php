<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AvatarPosesTableSeeder extends Seeder
{
    public function run()
    {
		$seeder = [
			[1, 1, 'Astronaut Female Pose Side', 'astronaut_female_0_side.png', 'Astronaut Female Pose Side'],
			[1, 2, 'Astronaut Female Pose 2', 'astronaut_female_2.png', 'Astronaut Female Pose 2'],
			[1, 3, 'Astronaut Female Pose 3', 'astronaut_female_3.png', 'Astronaut Female Pose 3'],
			[1, 4, 'Astronaut Female Pose 4', 'astronaut_female_4.png', 'Astronaut Female Pose 4'],
			[1, 5, 'Astronaut Female Pose 5', 'astronaut-female_5.png', 'Astronaut Female Pose 5'],
			[2, 6, 'Astronaut Male Pose Side', 'astronaut_male_0_side.png', 'Astronaut Male Pose Side'],
			[2, 7, 'Astronaut Male Pose 2', 'astronaut_male_2.png', 'Astronaut Male Pose 2'],
			[2, 8, 'Astronaut Male Pose 3', 'astronaut_male_3.png', 'Astronaut Male Pose 3'],
			[2, 9, 'Astronaut Male Pose 4', 'astronaut_male_4.png', 'Astronaut Male Pose 4'],
			[2, 10, 'Astronaut Male Pose 5', 'astronaut_male_5.png', 'Astronaut Male Pose 5'],
			[3, 11, 'Doctor Female Pose 3', 'doctor_female_3.png', 'Doctor Female Pose 3'],
			[3, 12, 'Doctor Female Pose 4', 'doctor_female_4.png', 'Doctor Female Pose 4'],
			[3, 13, 'Doctor Female Pose 5', 'doctor_female_5.png', 'Doctor Female Pose 5'],
			[3, 14, 'Doctor Female Pose 6', 'doctor_female_6.png', 'Doctor Female Pose 6'],
			[3, 15, 'Doctor Female Pose 7', 'doctor_female_7.png', 'Doctor Female Pose 7'],
			[4, 16, 'Doctor Male Pose 1', 'doctor_male-01.png', 'Doctor Male Pose 1'],
			[4, 17, 'Doctor Male Pose 2', 'doctor_male-02.png', 'Doctor Male Pose 2'],
			[4, 18, 'Doctor Male Pose 5', 'doctor_male-05.png', 'Doctor Male Pose 5'],
			[4, 19, 'Doctor Male Pose 6', 'doctor_male-06.png', 'Doctor Male Pose 6'],
			[4, 20, 'Doctor Male Pose 7', 'doctor_male-07.png', 'Doctor Male Pose 7'],
			[5, 21, 'Female Engineer Pose 2', 'engineer_female_2.png', 'Female Engineer Pose 2'],
			[5, 22, 'Female Engineer Pose 3', 'engineer_female_3.png', 'Female Engineer Pose 3'],
			[5, 23, 'Female Engineer Pose 5', 'engineer_female_5.png', 'Female Engineer Pose 5'],
			[5, 24, 'Female Engineer Pose 7', 'engineer_female_7.png', 'Female Engineer Pose 7'],
			[5, 25, 'Female Engineer Pose 8', 'engineer_female_8.png', 'Female Engineer Pose 8'],
			[6, 26, 'Male Engineer Pose 3', 'engineer_male_3.png', 'Male Engineer Pose 3'],
			[6, 27, 'Male Engineer Pose 4', 'engineer_male_4.png', 'Male Engineer Pose 4'],
			[6, 28, 'Male Engineer Pose 7', 'engineer_male_7.png', 'Male Engineer Pose 7'],
			[6, 29, 'Male Engineer Pose 9', 'engineer_male_9.png', 'Male Engineer Pose 9'],
			[6, 30, 'Male Engineer Pose 10', 'engineer_male_10.png', 'Male Engineer Pose 10'],
			[7, 31, 'Female Entrepreneur Pose 2', 'entrepreneur_female_2_2.png', 'Female Entrepreneur Pose 2'],
			[7, 32, 'Female Entrepreneur Pose 3', 'entrepreneur_female_3_2.png', 'Female Entrepreneur Pose 3'],
			[7, 33, 'Female Entrepreneur Pose 4', 'entrepreneur_female_4_2.png', 'Female Entrepreneur Pose 4'],
			[7, 34, 'Female Entrepreneur Pose 5', 'entrepreneur_female_5_2.png', 'Female Entrepreneur Pose 5'],
			[7, 35, 'Female Entrepreneur Pose 6', 'entrepreneur_female_6_2.png', 'Female Entrepreneur Pose 6'],
			[8, 36, 'Male Entrepreneur Pose 1', 'entrepreneur_male_1.png', 'Male Entrepreneur Pose 1'],
			[8, 37, 'Male Entrepreneur Pose 2', 'entrepreneur_male_2.png', 'Male Entrepreneur Pose 2'],
			[8, 38, 'Male Entrepreneur Pose 3', 'entrepreneur_male_3.png', 'Male Entrepreneur Pose 3'],
			[8, 39, 'Male Entrepreneur Pose 4', 'entrepreneur_male_4.png', 'Male Entrepreneur Pose 4'],
			[9, 40, 'Male Fireman Pose 2', 'fireman_2.png', 'Male Fireman Pose 2'],
			[9, 41, 'Male Fireman Pose 3', 'fireman_3.png', 'Male Fireman Pose 3'],
			[9, 42, 'Male Fireman Pose 10', 'fireman_10.png', 'Male Fireman Pose 10'],
			[9, 43, 'Male Fireman Pose 11', 'fireman_11.png', 'Male Fireman Pose 11'],
			[9, 44, 'Male Fireman Pose 13', 'fireman_13.png', 'Male Fireman Pose 13'],
			[10, 45, 'Female Firewoman Pose 1', 'firewoman_1.png', 'Female Firewoman Pose 1'],
			[10, 46, 'Female Firewoman Pose 3', 'firewoman_3.png', 'Female Firewoman Pose 3'],
			[10, 47, 'Female Firewoman Pose 9', 'firewoman_9.png', 'Female Firewoman Pose 9'],
			[10, 48, 'Female Firewoman Pose 11', 'firewoman_11.png', 'Female Firewoman Pose 11'],
			[10, 49, 'Female Firewoman Pose 13', 'firewoman_13.png', 'Female Firewoman Pose 13'],
			[12, 50, 'Female Pilot Pose 3', 'pilot_female_3.png', 'Female Pilot Pose 3'],
			[12, 51, 'Female Pilot Pose 5', 'pilot_female_5.png', 'Female Pilot Pose 5'],
			[12, 52, 'Female Pilot Pose 7', 'pilot_female_7.png', 'Female Pilot Pose 7'],
			[12, 53, 'Female Pilot Pose 9', 'pilot_female_9.png', 'Female Pilot Pose 9'],
			[12, 54, 'Female Pilot Pose 13', 'pilot_female_13.png', 'Female Pilot Pose 13'],
			[13, 55, 'Male Pilot Pose 3', 'pilot_male_3.png', 'Male Pilot Pose 3'],
			[13, 56, 'Male Pilot Pose 5', 'pilot_male_5.png', 'Male Pilot Pose 5'],
			[13, 57, 'Male Pilot Pose 7', 'pilot_male_7.png', 'Male Pilot Pose 7'],
			[13, 58, 'Male Pilot Pose 9', 'pilot_male_9.png', 'Male Pilot Pose 9'],
			[13, 59, 'Male Pilot Pose 14', 'pilot_male_14.png', 'Male Pilot Pose 14'],
			[16, 60, 'Female Teacher Pose 1', 'teacher_female_1.png', 'Female Teacher Pose 1'],
			[16, 61, 'Female Teacher Pose 3', 'teacher_female_3.png', 'Female Teacher Pose 3'],
			[16, 62, 'Female Teacher Pose 4', 'teacher_female_4.png', 'Female Teacher Pose 4'],
			[16, 63, 'Female Teacher Pose 5', 'teacher_female_5.png', 'Female Teacher Pose 5'],
			[16, 64, 'Female Teacher Pose 6', 'teacher_female_6.png', 'Female Teacher Pose 6'],
			[17, 65, 'Male Teacher Pose 1', 'teacher_male_1.png', 'Male Teacher Pose 1'],
			[17, 66, 'Male Teacher Pose 2', 'teacher_male_2.png', 'Male Teacher Pose 2'],
			[17, 67, 'Male Teacher Pose 3', 'teacher_male_3.png', 'Male Teacher Pose 3'],
			[17, 68, 'Male Teacher Pose 4', 'teacher_male_4.png', 'Male Teacher Pose 4'],
			[17, 69, 'Male Teacher Pose 5', 'teacher_male_5.png', 'Male Teacher Pose 5']
		];

		DB::table('avatar_poses')->truncate();

		foreach($seeder as $data){

			DB::table('avatar_poses')->insert([
				'avatar_id' => $data[0],
				'code' => $data[1],
				'name' => $data[2],
				'pose_image' => $data[3],
				'description' => $data[4],
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);

		}

    }
}
