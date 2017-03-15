<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Http\Requests\Api\DataLibraryRequest;
use FutureEd\Models\Repository\DataLibrary\DataLibraryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DataLibraryController extends ApiController {

	protected $data_library;

	public function __construct(
		DataLibraryRepositoryInterface $dataLibraryRepositoryInterface
	){
		$this->data_library = $dataLibraryRepositoryInterface;
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

		if(Input::get('object_type')){
			$criteria['object_type'] = Input::get('object_type');
		}

		if(Input::get('object_name')){
			$criteria['object_name'] = Input::get('object_name');
		}

		if(Input::get('status')){
			$criteria['status'] = Input::get('status');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->data_library->getDataLibraries($criteria,$limit,$offset));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param DataLibraryRequest $request
	 * @return Response
	 */
	public function store(DataLibraryRequest $request)
	{
		return $this->respondWithData($this->data_library->addDataLibrary($request->all()));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->data_library->getDataLibrary($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param DataLibraryRequest $request
	 * @return Response
	 */
	public function update($id, DataLibraryRequest $request)
	{
		return $this->respondWithData($this->data_library->updateDataLibrary($id,$request->all()));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return $this->respondWithData($this->data_library->deleteDataLibrary($id));
	}

}
