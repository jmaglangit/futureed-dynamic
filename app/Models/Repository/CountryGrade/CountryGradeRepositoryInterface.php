<?php namespace FutureEd\Models\Repository\CountryGrade;


interface CountryGradeRepositoryInterface {

	public function addCountryGrade($data);

	public function getCountryGradeByGrade($grade_id);

	public function updateAgeGroup($grade_id, $data);

}