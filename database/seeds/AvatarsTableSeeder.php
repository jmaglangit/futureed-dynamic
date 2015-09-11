<?php

use FutureEd\Models\Core\Avatar;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use League\Csv\Reader;



class AvatarsTableSeeder extends Seeder {


	public function run()
	{
		$reader = Reader::createFromPath('public/csv/avatars.csv');

		DB::table('avatars')->truncate();

		$i = 0;

		foreach($reader as $data){
			DB::table('avatars')->insert([
				'id' => $data[0],
				'code' => Carbon::now()->addMinute($i++)->timestamp,
				'gender' => $data[2],
				'avatar_image' => $data[3],
				'background_image' => $data[4],
				'points_to_unlock' => $data[5],
				'description' => $data[6],
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);

		}
	}




}