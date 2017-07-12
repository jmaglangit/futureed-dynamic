<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 10/3/16
 * Time: 3:17 PM
 */

namespace FutureEd\Models\Repository\ModuleCountry;

use FutureEd\Models\Core\ModuleCountry;

class ModuleCountryRepository implements ModuleCountryRepositoryInterface {

	public function getModuleCountries($criteria,$limit,$offset){

		$module_country = new ModuleCountry();

		$module_country = $module_country->with('grade','country','module');

		//get by criteria
		if(isset($criteria['module_id'])){
			$module_country = $module_country->whereModuleId($criteria['module_id']);
		}

		if(isset($criteria['module_name'])){
			$module_country = $module_country->ModuleName($criteria['module_name']);
		}

		if(isset($criteria['country_id'])){
			$module_country = $module_country->whereCountryId($criteria['country_id']);
		}

		if(isset($criteria['grade_id'])){
			$module_country = $module_country->whereGradeId($criteria['grade_id']);
		}

		if(isset($criteria['subject_id'])){
			$module_country = $module_country->subjectId($criteria['subject_id']);
		}

		if(isset($criteria['subject_name'])){
			$module_country = $module_country->subjectName($criteria['subject_name']);
		}

		if(isset($criteria['subject_area_name'])){
			$module_country = $module_country->subjectAreaName($criteria['subject_area_name']);
		}

		//student id
		if(isset($criteria['student_id'])){
			$module_country = $module_country->with('studentModule');

			$module_country = $module_country->student($criteria['student_id']);
		}

		//module status
		//age group id

		$count = $module_country->count();

		if ($limit > 0 && $offset >= 0) {
			$module_country = $module_country->offset($offset)->limit($limit);
		}

		$response = [
			'total' => $count,
			'records' => $module_country->get()->toArray()
		];

		return $response;
	}

	/**
	 * @param $module_id
	 * @param $data
	 * @return bool|static
	 */
	public function addModuleCountries($module_id,$data){

		DB::beginTransaction();

		try{

			$response = ModuleCountry::create([
				'module_id' => $module_id,
				'country_id' => $data['country_id'],
				'grade_id' => $data['grade_id'],
				'seq_no' => $data['seq_no']
			]);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $module_id
	 * @return mixed
	 */
	public function deleteModuleCountries($module_id){

		return ModuleCountry::where('module_id',$module_id)->delete();
	}

}