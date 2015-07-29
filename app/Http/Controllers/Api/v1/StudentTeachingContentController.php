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

		if(Input::get('content_id')){
			$criteria['content_id'] = Input::get('content_id');
		}

		$limit = (Input::get('limit')) ? Input::get('limit') : 0;
		$offset = (Input::get('offset')) ? Input::get('offset') : 0;

		return $this->respondWithData(
			$this->module_content->getModuleContentLists($criteria,$limit,$offset)
		);

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
