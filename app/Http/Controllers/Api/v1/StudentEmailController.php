<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use FutureEd\Http\Requests\Api\StudentEmailRequest;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\MailServices;

class StudentEmailController extends ApiController {

	protected $student;
	protected $client;
	protected $user;
	protected $code;
	protected $mail;

	public function __construct(
		StudentRepositoryInterface $student,
		ClientRepositoryInterface $client,
		UserRepositoryInterface $user,
		CodeGeneratorServices $code,
		MailServices $mail
	)
	{

		$this->student = $student;
		$this->client = $client;
		$this->user = $user;
		$this->code = $code;
		$this->mail = $mail;

	}

	//parent and teacher update student email
	public function updateStudentEmail($id,StudentEmailRequest $request)
	{
		$data = $request->only('email','new_email','client_id','password','callback_uri');

		//get student details
		$student_detail = $this->student->viewStudent($id);

		//check if student detail is empty
		if(!$student_detail){

			return $this->respondErrorMessage(2124);
		}

		//check if email is not correct
		if($student_detail['user']['email'] !== $data['email']){

			return $this->respondErrorMessage(2106);
		}

		$client_detail = $this->client->getClientDetails($data['client_id']);

		//check if client detail is empty
		if(!$client_detail){

			return $this->respondErrorMessage(2001);
		}

		//check if client_role is a principal:not authorize
		if($client_detail['client_role'] === config('futureed.principal')){

			return $this->respondErrorMessage(2234);
		}

		$password = sha1($data['password']);

		//check if password is correct and it will return the exact user_id
		$return  = $this->user->checkPassword($client_detail['user_id'],$password);

		//if return is empty it means password is not correct
		if(!$return){

			return $this->respondErrorMessage(2114);
		}

		//generate email code and email code expiry
		$code = $this->code->getCodeExpiry();

		//add email code and code expiry
		$user['new_email'] = $data['new_email'];
		$user['email_code'] = $code['confirmation_code'];
		$user['email_code_expiry'] = $code['confirmation_code_expiry'];


		//update the new_email of student
		$this->user->updateUser($student_detail['user_id'],$user);

		$user_detail = $this->user->getUserDetail($student_detail['user_id'],config('futureed.student'));

		//sent and email to student
		$this->mail->sendMailChangeEmail($user_detail,$code['confirmation_code'],$data['callback_uri'],0);

		return $this->respondWithData($this->student->viewStudent($id));

	}

}
