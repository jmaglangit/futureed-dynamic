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
					'grade_id' => $data[3],
					'code' => $data[4],
					'name' => $data[5],
					'description' => ($data[6] == '') ? '' : $data[5],
					'common_core_area' => $data[7],
					'common_core_url' => $data[8],
					'points_earned' => $data[9],
					'points_to_unlock' => $data[10],
					'points_to_finish' => $data[11],
					'status' => $data[12],
					'updated_by' => 1,
					'created_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);
		}
	}
}

