<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\School\SchoolRepositoryInterface;

use Illuminate\Http\Request;

class SchoolController extends ApiController {

	protected $school;

	public function __construct(SchoolRepositoryInterface $school){

		$this->school = $school;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        return  $this->respondWithData($this->school->getSchools());
	}

	public function show($code){

		//get school details using school code
		$school_detail = $this->school->getSchoolDetails($code);

		if(!$school_detail){

			return $this->respondErrorMessage(2120);
		}

		return $this->respondWithData($school_detail);


	}

	


}
