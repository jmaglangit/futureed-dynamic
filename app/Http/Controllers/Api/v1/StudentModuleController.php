<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\StudentModuleRequest;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Models\Repository\StudentModuleAnswer\StudentModuleAnswerRepositoryInterface;
use FutureEd\Services\StudentModuleServices;
use Illuminate\Support\Facades\Input;

class StudentModuleController extends ApiController {

	protected $module;
	protected $student_module;
	protected $question;
	protected $student_module_services;


	public function __construct(
		ModuleRepositoryInterface $moduleRepositoryInterface,
		StudentModuleRepositoryInterface $student_module,
		QuestionRepositoryInterface $questionRepositoryInterface,
		StudentModuleServices $studentModuleServices
	) {
		$this->module = $moduleRepositoryInterface;
		$this->student_module = $student_module;
		$this->question = $questionRepositoryInterface;
		$this->student_module_services = $studentModuleServices;
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
		if(Input::get('subject_id')){

			$criteria['subject_id'] = Input::get('subject_id');
		}

		//for student_id
		if(Input::get('student_id')){

			$criteria['student_id'] = Input::get('student_id');
		}

		//for class_id
		if(Input::get('class_id')){

			$criteria['class_id'] = Input::get('class_id');
		}

		//for grade
		if(Input::get('grade_id')){

			$criteria['grade_id'] = Input::get('grade_id');
		}

		//for module_status
		if(Input::get('module_status')){

			$criteria['module_status'] = Input::get('module_status');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		//get list of module
		return $this->respondWithData($this->module->getModules($criteria , $limit, $offset ));
	}

	/**
	 * Add new Student Module
	 * @param StudentModuleRequest $request
	 * @return json response
	 */
	public function store(StudentModuleRequest $request)
	{
		$data = $request->all();
		$data['module_status'] = config('futureed.module_status_ongoing');
		$data['date_start'] = Carbon::now();
		$data['date_end'] = Carbon::now();
		return $this->respondWithData($this->student_module->addStudentModule($data));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->student_module->viewStudentModule($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,StudentModuleRequest $request)
	{
		$data = $request->only('last_viewed_content_id','last_answered_question_id');

		$return = $this->student_module->updateStudentActivity($id,$data);

		//check if question id still exist else value 0.
		$student_module = $this->student_module->getStudentModule($id);
		$question = $this->question->getEnabledQuestion($student_module->last_answered_question_id);
		if(empty($question->toArray())){

			$data['last_answered_question_id'] = 0;

			//check for non-existing questions.
			$this->student_module_services->checkEnabledQuestions($id,$student_module->module_id);
		}

		if($return <> true){

			return $this->respondErrorMessage(7000);
		}


		return $this->respondWithData($this->student_module->viewStudentModule($id));
	}

}
