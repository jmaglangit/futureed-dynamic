<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\ModuleCountry\ModuleCountryRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use Illuminate\Support\Facades\Input;

class ModuleCountryController extends ApiController {

	protected $module_country;

	protected $student;

	public function __construct(
		ModuleCountryRepositoryInterface $moduleCountryRepositoryInterface,
		StudentRepositoryInterface $studentRepositoryInterface
	){
		$this->module_country = $moduleCountryRepositoryInterface;
		$this->student = $studentRepositoryInterface;
	}

	/**
	 * Get module country collection.
	 */
	public function index()
	{
		$category = [];

		//get module id
		if(Input::get('module_id')){
			$category['module_id'] = Input::get('module_id');
		}

		//get grade id
		if(Input::get('grade_id')){
			$category['grade_id'] = Input::get('grade_id');
		}

		//get country id
		if(Input::get('country_id')){
			$category['country_id'] = Input::get('country_id');
		}

		//get subject id
		if(Input::get('subject_id')){
			$category['subject_id'] = Input::get('subject_id');
		}

		//module student_id
		if(Input::get('student_id')){
			$category['student_id'] = Input::get('student_id');

			$student = $this->student->getStudent($category['student_id']);

			$category['country_id'] = $student->user->curriculum_country;

		}

		//module class_id
		if(Input::get('class_id')){
			$category['class_id'] = Input::get('class_id');
		}

		//module status
		if(Input::get('module_status')){
			$category['module_status'] = Input::get('module_status');
		}

		//age group
		if(Input::get('age_group_id')){
			$category['age_group_id'] = Input::get('age_group_id');
		}

		$limit = (Input::get('limit')) ? Input::get('limit') : 0;

		$offset = (Input::get('offset')) ? Input::get('offset') : 0;

		return $this->respondWithData($this->module_country->getModuleCountries($category,$limit,$offset));
	}


}
