<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Http\Requests\Api\ClientStudentRequest;

use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Models\Repository\ParentStudent\ParentStudentRepositoryInterface;
use FutureEd\Services\MailServices;

class ClientStudentController extends ApiController {

	protected $student;
	protected $user;
	protected $client;
	protected $code;
	protected $parent_student;
	protected $mail;

	public function __construct(
							StudentRepositoryInterface $student,
							UserRepositoryInterface $user,
							ClientRepositoryInterface $client,
							CodeGeneratorServices $code,
							ParentStudentRepositoryInterface $parent_student,
							MailServices $mail ){

			$this->student = $student;
			$this->user = $user;
			$this->client = $client;
			$this->code = $code;
			$this->parent_student = $parent_student;
			$this->mail = $mail;
	}

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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ClientStudentRequest $request)
	{
		//data for users table username,email,first_name,last_name,user_type
		$user_type = config('futureed.student');
		$user = $request->only('username','email','first_name','last_name');
		$user['user_type'] = $user_type;

		//initial data for parent_student
		$parent_student = $request->only('client_id');

		//url
		$url = $request->only('callback_uri');

		//data for students table
		$student = $request->only('first_name','last_name','gender','birth_date','country_id','city','state');

		//get parent details
		$client_detail = $this->client->getClientDetails($parent_student['client_id']);

		//check if client_detail is empty
		if(!$client_detail){

			return $this->respondErrorMessage(2001);
		}

		//check if client_role is not equal to Parent
		if($client_detail['client_role'] != config('futureed.parent')){

			return $this->respondErrorMessage(2032);
		}

		//generate confirmation_code
		$code = $this->code->getCodeExpiry();

		//add user to confirmation code and expiry
		$user['confirmation_code'] = $code['confirmation_code'];
		$user['confirmation_code_expiry'] = $code['confirmation_code_expiry'];

		//add to users table
		$this->user->addUser($user);

		//get user_id
		$user_id = $this->user->checkUserName($user['username'],$user_type);

		//add user_id to student
		$student['user_id'] = $user_id;

		//add to student table
		$this->student->addStudent($student);

		//get student_id using user_id
		$student_id = $this->student->getStudentId($user_id);

		//add student id to parent_student
		$parent_student['student_user_id'] = $student_id;

		//add parent_user_id to parent_student
		$parent_student['parent_user_id'] = $parent_student['client_id'];

		//add to parent_students table
		$this->parent_student->addParentStudent($parent_student);

		//form data needed for email (user_id,url)
		$this->mail->sendStudentRegister($user_id,$url['callback_uri']);

		return $this->respondWithData(['id' => $student_id]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 * for Parent and Teacher
	 */
	public function show($id)
	{
		//get student details by id and it return student details with relation to user,school and grade
		$student_detail = $this->student->viewStudent($id);

		//check if student_detail is empty
		if(!$student_detail){

			return $this->respondErrorMessage(2001);
		}

		//return student details if has values
		return $this->respondWithData($student_detail);


	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,ClientStudentRequest $request)
	{

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
