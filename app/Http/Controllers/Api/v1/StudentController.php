<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\StudentControllerRequest as StudentRequest;

use Illuminate\Support\Facades\Input;

class StudentController extends ApiController {

	/**
	 * Display all student.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];

		//get name
		if(Input::get('name')){

			$criteria['name'] = Input::get('name');
		}

		//get client_id/ parent_id
		if(Input::get('client_id')){

			$criteria['client_id'] = Input::get('client_id');
		}

		$limit = (Input::get('limit')) ? Input::get('limit') : 0;

		$offset = (Input::get('offset')) ? Input::get('offset') : 0;


		return $this->respondWithData($this->student->getStudents($criteria , $limit, $offset ));

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$error = config('futureed-error.error_messages');

        $this->addMessageBag($this->validateVarNumber($id));

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }
		if($this->student->checkIdExist($id)){
		     
	        $students = $this->student->getStudentDetails($id); 
	        return $this->respondWithData([
	            $students
	        ]);
	        	
	    }else{

	    	return $this->respondErrorMessage(2001);
	    }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param StudentRequest $request
	 * @param $id
	 * @return mixed
	 */
	public function update(StudentRequest $request ,$id)
	{

		$input = $request->only('first_name','last_name','gender','birth_date',
			              'email','username','grade_code','country_id','city','state');

        //check if username exist
        $check_username = $this->user->checkUsername($input['username'],config('futureed.student'));

        if( $check_username ){

        	$student_id = $this->student->getStudentId($check_username['user_id']);

        	if( $student_id != $id){

            	return $this->respondErrorMessage(2201);
            }

        }

        $this->student->updateStudentDetails($id,$input);
        $return = $this->student->getStudentDetails($id);

        return $this->respondWithData($return);

	}

	public function checkBillingAddress($id)
	{
		$student_details = $this->student->getStudent($id);

		if($student_details)
		{
			if($student_details->city == null
				|| $student_details->state == null
				|| $student_details->country_id == null)
			{
				return $this->respondWithData(['billing_address_not_found' => 1]);
			}
		}

		return $this->respondWithData(['billing_address_not_found' => 0]);
	}

}
