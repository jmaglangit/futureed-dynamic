<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\StudentModuleRequest;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use Illuminate\Support\Facades\Input;

class StudentModuleController extends ApiController {

	protected $module;
	protected $student_module;


	public function __construct(ModuleRepositoryInterface $moduleRepositoryInterface,
                                   StudentModuleRepositoryInterface $student_module)
	{
		$this->module = $moduleRepositoryInterface;
		$this->student_module = $student_module;
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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
	public function update($id,StudentModuleRequest $request)
	{
		$data = $request->only('last_viewed_content_id','last_answered_question_id');


		$return = $this->student_module->updateStudentActivity($id,$data);

		if($return <> true){

			return $this->respondErrorMessage(7000);
		}


		return $this->respondWithData($this->student_module->viewStudentModule($id));
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
