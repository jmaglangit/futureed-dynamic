<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/15
 * Time: 10:35 AM
 */

namespace FutureEd\Models\Repository\School;

use FutureEd\Models\Core\School;
use League\Flysystem\Exception;


class SchoolRepository implements SchoolRepositoryInterface{
	
	public function getSchools(){}

	public function getSchoolName($school_id){
		return School::select('name')->where('code','=',$school_id)->first();
	}
}