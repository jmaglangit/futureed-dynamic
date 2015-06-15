<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Http\Requests\Api\ParentStudentRequest;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\ParentStudent\ParentStudentRepositoryInterface;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\MailServices;



class ParentStudentController extends ApiController {


	protected $client;
	protected $code;
	protected $mail;
	protected $student;
	protected $user;
	protected $parent_student;

	public function __construct(
							StudentRepositoryInterface $student,
							ClientRepositoryInterface $client,
							UserRepositoryInterface $user,
							CodeGeneratorServices $code,
							MailServices $mail,
							ParentStudentRepositoryInterface $parent_student){

			$this->student = $student;
			$this->client = $client;
			$this->user = $user;
			$this->code = $code;
			$this->mail = $mail;
			$this->parent_student = $parent_student;

	}

	public function addExistingStudent(ParentStudentRequest $request){

		$data = $request->only('client_id','email');

		$client_detail = $this->client->getClientDetails($data['client_id']);

		//check if client_details is not empty
		if(!$client_detail){

			return $this->respondErrorMessage(2001);
		}

		//check if client_role is not Parent
		if($client_detail['client_role'] != config('futureed.parent')){

			return $this->respondErrorMessage(2032);
		}

		//returns user id
		$check_email = $this->user->checkEmail($data['email'], config('futureed.student'));

		//check if check_email is not empty
		if(!$check_email){

			return $this->respondErrorMessage(2002);
		}

		//get the student id using $check_email since $check_email content user_id
		$student_id = $this->student->getStudentId($check_email);

		//get user details
		$user_detail = $this->user->getUserDetail($check_email,config('futureed.student'));

		$parent_student_id = $this->parent_student->checkParentStudent($data['client_id'],$student_id);

		//if parent_student_id has value it means that parent already added a student
		if($parent_student_id){

			return $this->respondErrorMessage(2131);
		}

		//generate invitation_code
		$invitation_code = $this->code->getCode();

		//form data needed for adding (parent_user_id,student_user_id,invitation_code,status)
		$details['parent_user_id'] = $data['client_id'];
		$details['student_user_id'] = $student_id;
		$details['invitation_code'] = $invitation_code;
		$details['status'] = config('futureed.user_disabled');

		//add data to parent_students table
		$return = $this->parent_student->addParentStudent($details);

		//send email to student
		$this->mail->sendParentAddStudent($user_detail,$client_detail,$invitation_code);

		return $this->respondWithData(['id'=>$return['id']]);
	}

	public function parentConfirmStudent(ParentStudentRequest $request){

		$data = $request->only('client_id','invitation_code');

		$client_detail = $this->client->getClientDetails($data['client_id']);

		//check if client_details is not empty
		if(!$client_detail){

			return $this->respondErrorMessage(2001);
		}

		$parent_student_detail = $this->parent_student->checkInvitationCode($data['invitation_code'],$data['client_id']);

		//check if parent_student_detail is empty
		if(!$parent_student_detail){

			return $this->respondErrorMessage(2132);
		}

		$parent_student['status'] = config('futureed.user_enabled');
		$parent_student['invitation_code'] = NULL;

		//if client_id and invitation_code is correct update parent_student table
		$return = $this->parent_student->updateParentStudent($parent_student_detail['id'],$parent_student);

		return $this->respondWithData($return);

	}



}
