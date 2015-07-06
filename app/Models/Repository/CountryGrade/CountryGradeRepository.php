<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 7/6/15
 * Time: 11:12 AM
 */

namespace FutureEd\Models\Repository\CountryGrade;


use FutureEd\Models\Core\CountryGrade;

class CountryGradeRepository implements CountryGradeRepositoryInterface{

	public function addCountryGrade($data){
		try {

			return CountryGrade::create($data);

		} catch (Exception $e){

			return $e->getMessage();
		}
	}

}