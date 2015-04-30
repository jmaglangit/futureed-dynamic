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
use FutureEd\Services\CodeGeneratorServices;
use Carbon\Carbon;


class SchoolRepository implements SchoolRepositoryInterface{
	
	public function __construct(CodeGeneratorServices $code){
		$this->code = $code;
	}
	public function getSchools(){

        return School::all();
    }

	public function getSchoolName($school_code){

		return School::where('code','=',$school_code)->pluck('name');
	}

	public function addSchool($school){		
		$code = $code = Carbon::now()->timestamp;
		try{
			School::insert([
					'code' 				=> $code,
					'name' 				=> $school['school_name'],
					'street_address'	=> $school['school_address'],
					'city'				=> $school['school_city'],
					'state'				=> $school['school_state'],
					'country'			=> $school['school_country'],
					'zip'				=> $school['school_zip'],
					'created_by'		=> 1,
					'updated_by'		=> 1,
 				]);
		}catch(Exception $e){
			return $e->getMessage();
		}

		return true;
	}

	public function getSchoolId($name){
		//return user id
        return School::where('name','=',$name)->pluck('id');            
	}

	public function checkSchoolName($input){

		return School::where('name','=',$input['school_name'])
            ->where('street_address','=',$input['school_address'])
            ->where('state','=',$input['school_state'])->pluck('id');
	}
}