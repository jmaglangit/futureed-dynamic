<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use FutureEd\Http\Requests\Api\TeacherStudentRequest;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\MailServices;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use Carbon\Carbon;

class TeacherStudentController extends ApiController {

	protected $student;
	protected $user;
	protected $code;
	protected $mail;
	protected $class_student;

	public function __construct(
		StudentRepositoryInterface $student,
		UserRepositoryInterface $user,
		CodeGeneratorServices $code,
		MailServices $mail,
        ClassStudentRepositoryInterface $class_student
	)
	{
		$this->student = $student;
		$this->user = $user;
		$this->code = $code;
		$this->mail = $mail;
        $this->class_student = $class_student;

	}


	 // NOTE this process comes after teacher invite student and student confirm all the data.

	public function studentRegistrationAfterInvitation($id, TeacherStudentRequest $request)
	{
		//data for student table
		$student = $request->only('first_name','last_name','birth_date','gender','country_id','state','city','grade_code');

		//data needed for user table
		$user = $request->only('username','email');
		$user['name'] = $student['first_name'] .' '. $student['last_name'];
		$user['user_type'] = config('futureed.student');

		//callback_uri
		$url = $request->only('callback_uri');

		//get student detail
		$student_detail = $this->student->viewStudent($id);

		//check if student_detail is empty
		if(!$student_detail){

			return $this->respondErrorMessage(2001);
		}

		//get class student
		$class_student = $this->class_student->getStudentCurrentClassroom($id);

		if($class_student){

			$data['date_started'] = Carbon::now();

			$this->class_student->updateClassStudent($class_student['id'],$data);
		}

		//set registration code to NULL
		$user['registration_token'] = NULL;

		//generate confirmation code
		$code = $this->code->getCodeExpiry();

		//put confirmation code and confirmation code expiry to user
		$user['confirmation_code'] = $code['confirmation_code'];
		$user['confirmation_code_expiry'] = $code['confirmation_code_expiry'];

		//update users table using student_detail user_id
		$this->user->updateUser($student_detail['user_id'],$user);

		//update student table
		$this->student->updateStudentDetails($id,$student);

		//send email to student with confirmation code
		$this->mail->sendStudentRegister($student_detail['user_id'],$url['callback_uri']);

		//return updated student details
		return $this->respondWithData($this->student->viewStudent($id));

	}

	public function viewStudentDetailsByToken($id){

		$registration_token = NULL;

		if(Input::get('registration_token')){
			$registration_token = Input::get('registration_token');
		}

		$student = $this->student->viewStudentByToken($id, $registration_token);

		if(!$student){

			return $this->respondErrorMessage(2133);
		}

		return $this->respondWithData($student);
	}


}
