<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\ClassStudentRequest;

use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;

use FutureEd\Services\ClassroomServices;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\StudentServices;
use FutureEd\Services\UserServices;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class ClassStudentController extends ApiController {

    protected $class_student;
    protected $client;
    protected $mail;
    protected $student;
    protected $user;
    protected $classroom;
	protected $classroom_services;

    public function __construct(
		ClassStudentRepositoryInterface $classStudentRepositoryInterface,
		ClientRepositoryInterface $clientRepositoryInterface,
		UserServices $userServices,
		MailServices $mailServices,
		StudentServices $studentRepositoryInterface,
		ClassroomRepositoryInterface $classroom,
        	ClassroomServices $classroomServices
	)
	{
		$this->class_student = $classStudentRepositoryInterface;
		$this->client = $clientRepositoryInterface;
		$this->mail = $mailServices;
		$this->student = $studentRepositoryInterface;
		$this->user = $userServices;
		$this->classroom = $classroom;
        	$this->classroom_services = $classroomServices;
    }

    /**
     * Add new student via teacher inputting the details.
     * @param ClassStudentRequest $request
     * @return mixed
     *
     */
    public function addNewStudent(ClassStudentRequest $request)
    {
        $student = $request->only(
            'first_name',
            'last_name',
            'gender',
            'birth_date',
            'grade_code',
            'country_id',
            'state',
            'city');

        $user = $request->only(
            'username',
            'email',
            'first_name',
            'last_name');

        $class_student = $request->only('class_id','client_id');

        $callback_uri = $request->only('callback_uri');

        //check if username exist
        $check_username = $this->user->checkUsername($user['username'],config('futureed.student'));

        //check if email exist
        $check_email = $this->user->checkEmail($user['email'],config('futureed.student'));

		//get client details
		$client = $this->client->getClientDetails($class_student['client_id']);

		//assign to student the school of teacher
		$student['school_code'] = $client['school_code'];


        if($check_username){
            return $this->respondErrorMessage(2201);
        }

        if($check_email){
            return $this->respondErrorMessage(2200);
        }

		//check classroom has not expired.

		$classroom_status = $this->classroom_services->checkActiveClassroom($class_student['class_id']);

		if(!$classroom_status){

			return $this->respondErrorMessage(2051);
		}

        //check seats availability.
        $classroom = $this->classroom->getClassroom($class_student['class_id']);

        $user = array_merge($user,[
            'user_type' => config('futureed.student')
        ]);

        // add user, return status
        $user_response = $this->user->addUser($user);


        if(isset($user_response['status'])){
            $student = array_merge($student,[
                'user_id' => $user_response['id']
            ]);

            //add student, return status
            $student_response = $this->student->addStudent($student);

        } else {

            $return = $user_response;
            return $this->respondErrorMessage($return['error_code']);

        }

        if(isset($student_response['status'])){

            $student_id = $this->student->getStudentId($user_response['id']);

            //add class student.
            $class_student['student_id'] = $student_id;
            $class_student['status'] = 'Enabled';

            $this->class_student->addClassStudent($class_student);

            //increment seats_taken
            $classroom_data['seats_taken'] = $classroom->seats_taken + 1;
            $this->classroom->updateClassroom($classroom->id,$classroom_data);

            //send email to student.
            $client_user_id = $this->client->checkClient($class_student['client_id'],config('futureed.teacher'));
            $teacher = $this->user->getUser($client_user_id,config('futureed.client'));

            $email['user_id'] = $user_response['id'];
			$email['student_id'] = $student_id;
            $email['teacher_name'] = !is_null($teacher) ? $teacher['name'] : "";
            $email['url'] = $callback_uri['callback_uri'];

            $this->mail->sendMailInviteStudent($email);

            //return success
            return $this->respondWithData([
                'id' => $student_id
            ]);
        } else {

            //TODO: check if this is have been entered.
            $return = array_merge($user_response,$student_response);

            return $this->respondWithError($return);
        }

    }

    /**
     * Add existing student in a class via email.
     * @param ClassStudentRequest $request
     * @return mixed
     *
     */
    public function addExistingStudent(ClassStudentRequest $request)
    {
		$data = $request->all();
		$check_email = $this->user->checkEmail($data['email'], config('futureed.student'));

		if (!$check_email) {
			return $this->respondErrorMessage(2124);// Student does not exist.
		}

		$student_id = $this->student->getStudentId($check_email['user_id']);

		//check classroom has not expired.
		$classroom_status = $this->classroom_services->checkActiveClassroom($data['class_id']);

		if(!$classroom_status){

			return $this->respondErrorMessage(2051);
		}

		//check if student is added in a class already including inactive class
		$isEnrolled = $this->class_student->isEnrolled($student_id,$data['class_id']);

		if($isEnrolled){

			return $this->respondErrorMessage(2125);// Student is already in the class.
		}

		//Get current school if exist.
		$classroom = $this->class_student->getStudentCurrentClassroom($student_id);

		if ($classroom) {
			return $this->respondErrorMessage(2125);// Student is already in the class.
		}

        //check seats availability.
        $classroom = $this->classroom->getClassroom($data['class_id']);

		//add to class student table.
		$data['student_id'] = $student_id;
		$data['status'] = 'Enabled';
		$data['date_started'] = Carbon::now();
		$this->class_student->addClassStudent($data);

        //increment seats_taken
        $classroom_data['seats_taken'] = $classroom->seats_taken + 1;
        $this->classroom->updateClassroom($classroom->id,$classroom_data);

		//send email to student.
		$classroom = $this->class_student->getClassroom($data['class_id']);
		$client_user_id = $this->client->checkClient($data['client_id'], config('futureed.teacher'));
		$teacher = $this->user->getUser($client_user_id, config('futureed.client'));

		//update school code of student.
		$client_school_code = $this->client->getSchoolCode($data['client_id']);

		$this->student->updateSchool($student_id, $client_school_code);


		$data['user_id'] = $check_email['user_id'];
		$data['class_name'] = $classroom ? $classroom['name'] : "";
		$data['teacher_name'] = !is_null($teacher) ? $teacher['name'] : "";

		$this->mail->sendExistingStudentRegister($data);

		//return success
		return $this->respondWithData(['id' => $student_id]);

    }

	/**
	 * Student Joins the class.
	 * @param $id
	 * @return mixed
	 */
	public function studentCurrentClass(ClassStudentRequest $request){

		return $this->respondWithData(
			$this->student->getCurrentClass($request->get('student_id'))
		);
	}

}
