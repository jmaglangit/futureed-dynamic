<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\AdminStudentRequest;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\MailServices;

class AdminStudentController extends ApiController {

    public function __construct(UserRepositoryInterface $user, StudentRepositoryInterface $student,
                                CodeGeneratorServices $code, MailServices $mail ){

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
	public function store(AdminStudentRequest $request)
	{
        $user = $request->only('username','email');

        $student = $request->only('first_name','last_name','gender','birth_date','country','state','city','school_code','grade_code');
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

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
