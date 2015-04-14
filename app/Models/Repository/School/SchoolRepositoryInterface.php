<?php


namespace FutureEd\Models\Repository\School;

interface SchoolRepositoryInterface {
	
	public function getSchools();
	
    public function getSchool($school_id);

}