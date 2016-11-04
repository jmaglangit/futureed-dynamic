<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\ModuleCountry\ModuleCountryRepositoryInterface;
use Illuminate\Support\Facades\Input;

class ModuleCountryController extends ApiController {

	protected $module_country;

	public function __construct(
		ModuleCountryRepositoryInterface $moduleCountryRepositoryInterface
	){
		$this->module_country = $moduleCountryRepositoryInterface;
	}

	/**
	 * Get module country collection.
	 */
	public function index()
	{
		$category = [];

		if(Input::get('module_id')){
			$category['module_id'] = Input::get('module_id');
		}

		if(Input::get('grade_id')){
			$category['grade_id'] = Input::get('grade_id');
		}

		if(Input::get('country_id')){
			$category['country_id'] = Input::get('country_id');
		}

		if(Input::get('subject_id')){
			$category['subject_id'] = Input::get('subject_id');
		}

		$limit = (Input::get('limit')) ? Input::get('limit') : 0;

		$offset = (Input::get('offset')) ? Input::get('offset') : 0;

		return $this->respondWithData($this->module_country->getModuleCountries($category,$limit,$offset));
	}


}
