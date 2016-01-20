<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Services\StudentServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ModuleController extends ApiController {

	protected $module;

	protected $student_services;

	protected $student;

	protected $user;

	public function __construct(
		ModuleRepositoryInterface $moduleRepositoryInterface,
		StudentServices $studentServices,
		StudentRepositoryInterface $studentRepositoryInterface,
		UserRepositoryInterface $userRepositoryInterface
	){

		$this->module = $moduleRepositoryInterface;
		$this->student_services = $studentServices;
		$this->student = $studentRepositoryInterface;
		$this->user = $userRepositoryInterface;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0 ;
		$offset = 0;



		//for module name
		if(Input::get('name')){

			$criteria['name'] = Input::get('name');
		}

		//for subject
		if(Input::get('subject')){

			$criteria['subject'] = Input::get('subject');
		}

		//for subject_id
		if(Input::get('subject_id')){

			$criteria['subject_id'] = Input::get('subject_id');
		}

		//for grade_id
		if(Input::get('grade_id')){

			$criteria['grade_id'] = Input::get('grade_id');
		}

		//Age Group
		//for subject
		if(Input::get('age_group_id')){

			$criteria['age_group_id'] = Input::get('age_group_id');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		//get module list with relation to subject,subject_area,grade
		return $this->respondWithData($this->module->getModules($criteria , $limit, $offset ));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		//check if user is student
		$user = $this->user->getUser(session('current_user'));

		if($user->user_type == config('futureed.student')){

			//get student id
			$student_id = $this->student->getStudentId(session('current_user'));

			//validate student if it has access.

			$is_valid = $this->student_services->checkStudentValidModule($student_id,$id);

			if(!$is_valid){

				return $this->respondErrorMessage(2070);
			}
		}

		return $this->respondWithData(
			$this->module->viewModule($id)
		);
	}

}
