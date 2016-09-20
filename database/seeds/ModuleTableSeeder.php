<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Carbon\Carbon;

// composer require laracasts/testdummy


class ModuleTableSeeder extends Seeder
{
    public function run()
    {
//		id,subject_id,area_id,code,name,description,common_core_area,common_core_url,points_earned,points_to_unlock,
//		points_to_finish,status,created_by,,created_at,updated_at,deleted_at

		//GET SEED DATA.
		$reader = Reader::createFromPath( storage_path('seeders') . '/modules.csv');

		$seeds = [];

		foreach($reader as $data){

			array_push($seeds,[
				'subject_id' => $data[1],
				'subject_area_id' => ($data[2] == '') ? 0 : $data[2],
				'grade_id' => $data[3],
				'code' => $data[4],
				'name' => $data[5],
				'icon_image' => $data[6],
				'original_icon_image' => $data[7],
				'description' => ($data[8] == '') ? '' : $data[8],
				'common_core_area' => $data[9],
				'common_core_url' => $data[10],
				'points_earned' => $data[11],
				'points_to_unlock' => $data[12],
				'points_to_finish' => $data[13],
				'status' => $data[14],
				'updated_by' => 1,
				'created_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);
		}

		//clear table before initial insert
		\DB::table('modules')->truncate();
		\DB::table('modules')->insert($seeds);

		//initialize en to module_translations
		$this->addTranslation();

	}

	/**
	 * Add module name to module translation for initial english translations.
	 */
	public function addTranslation(){

		DB::table('module_translations')->truncate();

		$modules_count = DB::table('modules')->count();

		$locales = config('translatable.locales');

		foreach($locales as $locale){

			$limit = config('futureed.seeder_record_limit');
			$offset = 0;

			for($i=0;$i < ceil(($modules_count/$limit)); $i++){

				//loop throughout the table.
				$module_data =  DB::table('modules')->select('id', 'name','description')
					->skip($offset)->limit($limit)->get();

				$offset += $limit;

				$translation = [];
				foreach ($module_data as $module => $m) {

					array_push($translation, [
						'module_id' => $m->id,
						'name' => $m->name,
						'description' => $m->description,
						'locale' => $locale,
						'created_by' => 1,
						'updated_by' => 1,
						'created_at' => Carbon::now(),
						'updated_at' => Carbon::now()
					]);
				}

				DB::table('module_translations')->insert($translation);
			}
		}



	}
}

