<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use Illuminate\Http\Request;

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


		
		//for module name
		if(Input::get('name')){

			$criteria['name'] = Input::get('name');
		}

		//for subject
		if(Input::get('subject')){

			$criteria['subject'] = Input::get('subject');
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
