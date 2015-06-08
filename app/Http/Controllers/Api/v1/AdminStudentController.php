<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\AdminStudentRequest;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\MailServices;

use Illuminate\Support\Facades\Input;

class AdminStudentController extends ApiController {

	public function __construct(
			UserRepositoryInterface $user,
			StudentRepositoryInterface $student,
			CodeGeneratorServices $code,
			MailServices $mail ){

		$this->user = $user;
		$this->student = $student;
		$this->code = $code;
		$this->mail = $mail;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        $criteria = array();
        $limit = 0;
        $offset = 0;

        if(Input::get('name')) {
            $criteria['name'] = Input::get('name');
        }

        if(Input::get('email')){

            $criteria['email'] = Input::get('email');
        }

        if(Input::get('limit')){

            $limit = Input::get('limit');
        }

        if(Input::get('offset')){

            $offset = Input::get('offset');
        }

        $student = $this->student->getStudentList($criteria,$limit,$offset);

        return $this->respondWithData($student);


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
	public function store(AdminStudentRequest $request)
	{
        $user = $request->only('username','email');

        $student = $request->only('first_name','last_name','gender','birth_date','country','country_id','state','city','school_code','grade_code');
        $url = $request->only('callback_uri');

        $user['first_name'] = $student['first_name'];
        $user['last_name'] = $student['last_name'];
        $user['user_type'] = config('futureed.student');

        $code = $this->code->getCodeExpiry();

        $user['confirmation_code'] = $code['confirmation_code'];
        $user['confirmation_code_expiry'] = $code['confirmation_code_expiry'];

        //add user
        $this->user->addUser($user);

        //get user_id using username
        $user_id = $this->user->checkUserName($user['username'],$user['user_type']);

        $student['user_id'] = $user_id;

        //add student
        $this->student->addStudent($student);

        $student_id = $this->student->getStudentId($user_id);

        //sent email on student
        $this->mail->sendStudentRegister($user_id,$url['callback_uri']);

        return $this->respondWithData(['id' => $student_id]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $student = $this->student->viewStudent($id);

        if(!$student){

            return $this->respondErrorMessage(2001);
        }

        return $this->respondWithData($student);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,AdminStudentRequest $request)
	{
        $data = $request->only('first_name','last_name','gender','birth_date','country','state','city','country_id','school_code','grade_code');
        $user = $request->only('username','email');
        $user_type = config('futureed.student');

        $user['name'] = $data['first_name'].$data['last_name'];

        $student = $this->student->viewStudent($id);

        //check username
        $username = $this->user->checkUserName($user['username'],$user_type);

        //check email
        $email = $this->user->checkEmail($user['email'],$user_type);

        if($username && $username != $student['user_id']){

            return $this->respondErrorMessage(2201);
        }

        if($email && $email != $student['user_id']){

            return $this->respondErrorMessage(2200);
        }

        if(!$student){

            return $this->respondErrorMessage(2001);
        }

        //update user
        $this->user->updateUser($student['user_id'], $user);

        //update student
        $this->student->updateStudentDetails($id, $data);

        $return = $this->student->viewStudent($id);

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
		$student = $this->student->viewStudentClassBadge($id);

		if(!$student){

			return $this->respondErrorMessage(2001);

		}

		if($student['parent_id']){

			return $this->respondErrorMessage(2126);
		}

		if($student['points']){

			return $this->respondErrorMessage(2127);
		}

		if($student['badge']){

			return $this->respondErrorMessage(2128);
		}

		if($student['classroom']){

			return $this->respondErrorMessage(2129);

		}

		return $this->respondWithData($this->student->deleteStudent($id));


	}

}
