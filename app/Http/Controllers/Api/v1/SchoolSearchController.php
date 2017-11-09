<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SchoolSearchController extends SchoolController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */


	public function schoolSearch(){
		
		$input = Input::only('school_name');
		
		//returns all school details if available
		$return = $this->school->searchSchool($input['school_name']);


		if(!$return){

			return $this->respondErrorMessage(2116);

		}else{

			return $this->respondWithData($return);

		}
	}

	

}