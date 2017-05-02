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

    public function getSchoolCode($school_name);

    public function searchSchool($school_name);

    public function getSchoolByCode($school_code);

    public function getSchoolAreaRanking($school_code);

    public function getSchoolClassRanking($school_code);

    public function getSchoolStudentRanking($school_code);

    public function getSchoolStudentScores($school_code);

    public function getSchoolSubjectProgress($school_code, $grade_level);

}