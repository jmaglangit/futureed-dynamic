<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class StudentController extends ApiController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{        
        $students = $this->student->getStudentDetails($id); 
        return $this->respondWithData([
            $students
        ]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::only('first_name','last_name','gender','birth_date',
							'email','username','school_code','grade_code',
							'country','city','state');
		
		if(!$input['first_name'] || !$input['last_name'] || !$input['gender'] || 
			!$input['birth_date'] || !$input['email'] || !$input['username'] || 
			!$input['school_code'] || !$input['grade_code'] || !$input['country'] ||
			!$input['city'] || !$input['state']) {
		
				return $this->setStatusCode(422)
						->respondWithError(['error_code'=>422,
						'message'=>'Parameter validation failed'
						]);
		} else {
		
			$return = $this->student->validateStudentDetails($input);
			
			if($return['status']==200){
				$this->student->updateStudentDetails($id,$input);
				return $this->respondWithData(['id'=>$id]);
			
			} else {
			
				return $this->setStatusCode(202)
				->respondWithData(['error_code'=>202,
				'message'=>$return['data']]); 
			
			}
		}	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
