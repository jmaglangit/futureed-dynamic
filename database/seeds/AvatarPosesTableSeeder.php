<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Carbon\Carbon;

class AvatarPosesTableSeeder extends Seeder
{
    public function run()
    {

		//id,avatar_id,code,name,pose_image,description,created_by,updated_by,created_at,updated_at,deleted_at

		$reader = Reader::createFromPath('public/csv/avatar_poses.csv');

		DB::table('avatar_poses')->truncate();

		foreach($reader as $data){

			DB::table('avatar_poses')->insert([
				'avatar_id' => $data[1],
				'code' => $data[2],
				'name' => $data[3],
				'pose_image' => $data[4],
				'description' => $data[5],
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);

		}

    }
}
