<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Carbon\Carbon;

class AvatarAccessoriesTableSeeder extends Seeder
{
    public function run()
    {
        //id,code,name,avatar_id,accessory_image,points_to_unlock,description,created_by,updated_by,deleted_at,created_at,updated_at

        $reader = Reader::createFromPath(storage_path('seeders') . '/avatar_accessories.csv');

		DB::table('avatar_accessories')->truncate();

		foreach($reader as $data){

			DB::table('avatar_accessories')->insert([
				'id' => $data[0],
				'code' => $data[1],
				'name' => $data[2],
				'avatar_id' => $data[3],
				'accessory_image' => $data[4],
				'points_to_unlock' => $data[5],
				'description' => $data[6],
				'created_by' => $data[7],
				'updated_by' => $data[8],
				'deleted_at' => null,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);

		}
    }
}
