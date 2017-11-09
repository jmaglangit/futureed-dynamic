<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 7/6/15
 * Time: 11:12 AM
 */

namespace FutureEd\Models\Repository\CountryGrade;


use FutureEd\Models\Core\CountryGrade;
use FutureEd\Models\Traits\LoggerTrait;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;

class CountryGradeRepository implements CountryGradeRepositoryInterface{
	use LoggerTrait;

	/**
	 * Add Country Grade.
	 * @param $data
	 * @return string|static
	 */
	public function addCountryGrade($data){
		DB::beginTransaction();

		try {
			$response = CountryGrade::create($data);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Country Grade by grade_id.
	 * @param $grade_id
	 * @return mixed
	 */
	public function getCountryGradeByGrade($grade_id){
		DB::beginTransaction();

		try{
			$response = CountryGrade::gradeId($grade_id)->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update Country Grade by grade_id.
	 * @param $grade_id
	 * @param $data
	 * @return mixed|string
	 */
	public function updateAgeGroup($grade_id, $data){
		DB::beginTransaction();

		try{
			CountryGrade::gradeId($grade_id)->update($data);

			$response = $this->getCountryGradeByGrade($grade_id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

}