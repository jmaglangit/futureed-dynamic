<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\ModuleContent\ModuleContentRepositoryInterface;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class StudentTeachingContentController extends ApiController {

	protected $module_content;

	public function __construct(ModuleContentRepositoryInterface $module_content){

		$this->module_content = $module_content;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$criteria = [];

		if(Input::get('module_id')){
			$criteria['module_id'] = Input::get('module_id');
		}

		$limit = (Input::get('limit')) ? Input::get('limit') : 0;
		$offset = (Input::get('offset')) ? Input::get('offset') : 0;

		return $this->respondWithData(
			$this->module_content->getModuleContentLists($criteria,$limit,$offset)
		);

	}

}
