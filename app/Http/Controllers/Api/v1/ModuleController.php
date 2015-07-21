<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ModuleController extends ApiController {

	protected $module;

	public function __construct(
		ModuleRepositoryInterface $moduleRepositoryInterface
	){

		$this->module = $moduleRepositoryInterface;

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

		//for subject
		if(Input::get('subject_id')){

			$criteria['subject_id'] = Input::get('subject_id');
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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData(
			$this->module->viewModule($id)
		);
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
