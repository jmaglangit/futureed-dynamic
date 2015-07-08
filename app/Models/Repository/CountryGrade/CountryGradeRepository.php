<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 7/6/15
 * Time: 11:12 AM
 */

namespace FutureEd\Models\Repository\CountryGrade;


use FutureEd\Models\Core\CountryGrade;
use League\Flysystem\Exception;

class CountryGradeRepository implements CountryGradeRepositoryInterface{

	/**
	 * Add Country Grade.
	 * @param $data
	 * @return string|static
	 */
	public function addCountryGrade($data){
		try {

			return CountryGrade::create($data);

		} catch (Exception $e){

			return $e->getMessage();
		}
	}

	/**
	 * Get Country Grade by grade_id.
	 * @param $grade_id
	 * @return mixed
	 */
	public function getCountryGradeByGrade($grade_id){

		return CountryGrade::gradeId($grade_id)->first();
	}

	/**
	 * Update Country Grade by grade_id.
	 * @param $grade_id
	 * @param $data
	 * @return mixed|string
	 */
	public function updateAgeGroup($grade_id, $data){

		try{

			CountryGrade::gradeId($grade_id)
				->update($data);

			return $this->getCountryGradeByGrade($grade_id);

		} catch(Exception $e){

			return $e->getMessage();
		}
	}

}