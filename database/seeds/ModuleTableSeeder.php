<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Carbon\Carbon;

// composer require laracasts/testdummy


class ModuleTableSeeder extends Seeder
{
    public function run()
    {
//		id,subject_id,area_id,code,name,description,common_core_area,common_core_url,points_earned,points_to_unlock,
//		points_to_finish,status,created_by,,created_at,updated_at,deleted_at

		//TODO:: GET SEED DATA.
		$reader = Reader::createFromPath('public/csv/modules.csv');

		\DB::table('modules')->truncate();

		foreach($reader as $data){


			\DB::table('modules')->insert([
				[
					'subject_id' => $data[1],
					'subject_area_id' => ($data[2] == '') ? 0 : $data[2],
					'code' => $data[3],
					'name' => $data[4],
					'grade_id' => 1,
					'description' => $data[5],
					'common_core_area' => $data[6],
					'common_core_url' => $data[7],
					'points_earned' => $data[8],
					'points_to_unlock' => $data[9],
					'points_to_finish' => $data[10],
					'status' => $data[11],
					'updated_by' => 1,
					'created_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);
		}
	}
}

