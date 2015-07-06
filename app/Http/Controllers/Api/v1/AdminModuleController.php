<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\AdminModuleRequest;
use Illuminate\Support\Facades\Input;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;

use Illuminate\Http\Request;

class AdminModuleController extends ApiController {

	protected $module;

	public function __construct(ModuleRepositoryInterface $module){

		$this->module = $module;

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

		//for area
		if(Input::get('area')){

			$criteria['area'] = Input::get('area');
		}

		//for subject
		if(Input::get('subject')){

			$criteria['subject'] = Input::get('subject');
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
	public function store(AdminModuleRequest $request)
	{
		$data = $request->only('subject_id','subject_area_id','name','code','description','common_core_area',
                                      'common_core_url','status','points_to_unlock','points_to_finish');

		if($data['points_to_unlock'] >= $data['points_to_finish']){

			return $this->respondErrorMessage(2139);
		}

		$return = $this->module->addModule($data);

		return $this->respondWithData(['id'=>$return['id']]);


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
	public function update($id, AdminModuleRequest $request)
	{
		$data = $request->only('subject_id','subject_area_id','name','description','common_core_area',
					'common_core_url','status','points_to_unlock','points_to_finish');

		$module = $this->module->viewModule($id);

		if(!$module){

			return $this->respondErrorMessage(2120);
		}

		if($data['points_to_unlock'] >= $data['points_to_finish']){

			return $this->respondErrorMessage(2139);
		}

		//update module
		$this->module->updateModule($id,$data);

		return $this->respondWithData($this->module->viewModule($id));


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
