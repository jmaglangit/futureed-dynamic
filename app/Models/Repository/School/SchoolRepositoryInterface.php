<?php


namespace FutureEd\Models\Repository\School;

interface SchoolRepositoryInterface {
	
	public function getSchools();
	
    public function getSchoolName($school_id);

}