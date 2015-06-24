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
				'code' => $code,
				'name' => $school['school_name'],
				'street_address' => $school['school_address'],
				'city' => $school['school_city'],
				'state' => $school['school_state'],
				'country' => isset($school['school_country']) ? $school['school_country'] : 0,
				'country_id' => $school['school_country_id'],
				'zip' => $school['school_zip'],
				'contact_name' => $school['contact_name'],
				'contact_number' => $school['contact_number'],
				'created_by' => 1,
				'updated_by' => 1,
			]);
		}catch(Exception $e){
			return $e->getMessage();
		}

		return $code;
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

	public function getSchoolDetails($id){

		return School::where('code','=',$id)->first();

	}

	public function checkSchoolNameExist($input){

		return School::where('name','=',$input['school_name'])
            ->where('street_address','=',$input['school_street_address'])
            ->where('state','=',$input['school_state'])->pluck('code');
	}

	public function updateSchoolDetails($input){


		foreach ($input as $key => $value) {

			if($value !=null ){

		 		$update[substr($key,7)] = $value;

		 	}else{ 

		 		$update[substr($key,7)] = null;

		 	}
	
		}

		try{

			School::where('code',$input['school_code'])->update($update);

		}catch(Exception $e){
			return $e->getMessage();
		}


	}

	public function getSchoolCode($school_name){

		return School::where('name','=',$school_name)->pluck('code');

	}

	public function searchSchool($school_name){

		return School::select('name','code','city','state','street_address')
						->where('name','Like',$school_name.'%')->get()->toArray();


	}




}