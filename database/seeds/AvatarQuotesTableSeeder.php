<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AvatarQuotesTableSeeder extends Seeder
{

	public function run()
	{
		DB::table('avatar_quotes')->truncate();

		//1 loop 4, 3, 5, 1,2
		//2 Loop 10, 9, 7,6,8
		//3 Loop 12, 13,15,11,14
		//4 Loop 18,20,17,19,16,
		//5 Loop 21,24,23,25,22,
		//6 Loop 26,29,28,30,27
		//7 Loop 35,32,34,33,31
		//8 Loop 38,39,36,36,36
		//9 Loop 40,41,43,42,44
		//10 Loop 45, 46,48,47,49
		//11 Loop 50,54,52,53,51
		//12 Loop 55,59,57,58,56
		//13 Loop 63,64,62,61,60
		//14 Loop 68,65,67,67,66

		$seeder_data = [
			[4, 3, 5, 1, 2],
			[10, 9, 7, 6, 8],
			[12, 13, 15, 11, 14],
			[18, 20, 17, 19, 16,],
			[21, 24, 23, 25, 22,],
			[26, 29, 28, 30, 27],
			[35, 32, 34, 33, 31],
			[38, 39, 36, 36, 36],
			[40, 41, 43, 42, 44],
			[45, 46, 48, 47, 49],
			[50, 54, 52, 53, 51],
			[55, 59, 57, 58, 56],
			[63, 64, 62, 61, 60],
			[68, 65, 67, 67, 66]
		];

		$avatar_id = 1;
		foreach ($seeder_data as $data) {
			//Loop Start
			$sequence = 1;

			$repeat = [6, 6, 5, 4, 2];

			for ($i = 0; $i < 5; $i++) {

				for ($loop = 0; $loop < $repeat[$i]; $loop++) {

					DB::table('avatar_quotes')->insert([
						'avatar_id' => $avatar_id,
						'avatar_pose_id' => $data[$i],
						'quote_id' => $sequence,
						'created_by' => 1,
						'updated_by' => 1,
						'created_at' => Carbon::now(),
						'updated_at' => Carbon::now()
					]);
					$sequence++;
				}
			}
			$avatar_id++;
		}

		$seeder_data = [4, 10, 12, 18, 21,26,35,38,40,45,50,55,63,68];
		$avatar_id = 1;
		foreach($seeder_data as $seed){

			$quote_id = 24;
			if( $avatar_id == 11){
				$avatar_id = 12;//skip id 11
			}
			if($avatar_id == 14){
				$avatar_id = 16;//skip ids 14 to 15
			}

			for($i = 0; $i < 6; $i++){
				DB::table('avatar_quotes')->insert([
					'avatar_id' => $avatar_id,
					'avatar_pose_id' => $seed,
					'quote_id' => $quote_id,
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]);
				$quote_id++;
			}
			$avatar_id++;
		}
	}
}
