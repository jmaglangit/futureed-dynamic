<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use Illuminate\Http\Request;
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

		$limit = (Input::get('limit')) ? Input::get('limit') : 0;

		$offset = (Input::get('offset')) ? Input::get('offset') : 0;


		return $this->respondWithData($this->student->getStudents($criteria , $limit, $offset ));

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
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		$input = Input::only('first_name','last_name','gender','birth_date',
							'email','username','grade_code','country_id',
							'country','city','state');

        //Student fields validations
        $this->addMessageBag($this->firstName($input,'first_name'));
        $this->addMessageBag($this->lastName($input,'last_name'));
        $this->addMessageBag($this->gender($input,'gender'));
        $this->addMessageBag($this->editBirthDate($input,'birth_date'));
        $this->addMessageBag($this->validateNumber($input,'grade_code'));
        $this->addMessageBag($this->validateNumber($input,'country_id'));
        $this->addMessageBag($this->validateString($input,'country'));
        $this->addMessageBag($this->validateString($input,'city'));
		$this->addMessageBag($this->validateStringOptional($input,'state'));

        //User fields validations
        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->username($input, 'username'));

        $msg_bag = $this->getMessageBag();
        
        if(!empty($msg_bag)){

            return $this->respondWithError($this->getMessageBag());
        }

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
