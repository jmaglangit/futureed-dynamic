<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\MediaType\MediaTypeRepositoryInterface;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class AdminMediaTypeController extends ApiController {

	protected $media_type;

	public function __construct(MediaTypeRepositoryInterface $media_type ){

		$this->media_type = $media_type;

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


		//for name
		if(Input::get('name')){

			$criteria['name'] = Input::get('name');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		$record = $this->media_type->getMediaTypes($criteria , $limit, $offset );


		return $this->respondWithData($record);
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
