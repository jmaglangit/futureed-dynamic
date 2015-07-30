<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;

class PointLevelTableSeeder extends Seeder
{
    public function run()
    {
		$seeder = [
			['Bronze','1000','bronze','bronze.png','1','1'],
			['Silver','2000','silver','silver.png','1','1'],
			['Gold','3000','gold','gold.png','1','1'],

		];


		\DB::table('point_levels')->truncate();

		foreach($seeder as $data){

			DB::table('point_levels')->insert([
			'name' => $data[0],
			'points_required' => $data[1],
			'description' => $data[2],
			'filename' => $data[3],
			'created_by' => $data[4],
			'updated_by' => $data[5],
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now()
			]);
		}

	}


}
