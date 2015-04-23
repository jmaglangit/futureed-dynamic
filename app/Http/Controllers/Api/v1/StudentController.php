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

        //Student fields validations
        $this->addMessageBag($this->firstName($input,'first_name'));
        $this->addMessageBag($this->lastName($input,'last_name'));
        $this->addMessageBag($this->gender($input,'gender'));
        $this->addMessageBag($this->birthDate($input,'birth_date'));
        $this->addMessageBag($this->validateNumber($input,'school_code'));
        $this->addMessageBag($this->validateNumber($input,'grade_code'));
        $this->addMessageBag($this->validateString($input,'country'));
        $this->addMessageBag($this->validateString($input,'state'));
        $this->addMessageBag($this->validateString($input,'city'));

        //User fields validations
        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->username($input, 'username'));

        $msg_bag = $this->getMessageBag();
        
        if(!empty($msg_bag)){

            return $this->respondWithError($this->getMessageBag());
        }

        $this->student->updateStudentDetails($id,$input);

        return $this->respondWithData(['id'=>$id]);

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
