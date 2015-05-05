<?php


namespace FutureEd\Models\Repository\School;

interface SchoolRepositoryInterface {
	
	public function getSchools();
	
    public function getSchoolName($school_id);

    public function addSchool($school);

    public function getSchoolId($name);

    public function checkSchoolName($input);

    public function getSchoolDetails($id);

    public function checkSchoolNameExist($input);

    public function updateSchoolDetails($input);
}