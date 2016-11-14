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

		if(isset($criteria['country_id'])){
			$module_country = $module_country->whereCountryId($criteria['country_id']);
		}

		if(isset($criteria['grade_id'])){
			$module_country = $module_country->whereGradeId($criteria['grade_id']);
		}

		if(isset($criteria['subject_id'])){
			$module_country = $module_country->subjectId($criteria['subject_id']);
		}

		//student id
		if(isset($criteria['student_id'])){
			$module_country = $module_country->with('studentModule');

			$module_country = $module_country->student($criteria['student_id']);
		}

		//class id
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

}