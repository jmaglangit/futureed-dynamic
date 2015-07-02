<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use FutureEd\Models\Repository\Tip\TipRepositoryInterface;

use Illuminate\Http\Request;

class TeacherTipController extends ApiController {

	protected $tip;

	public function __construct(TipRepositoryInterface $tip){

		$this->tip = $tip;
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

		//for class_id
		if(Input::get('class_id')){

			$criteria['class_id'] = Input::get('class_id');
		}

		//for created
		if(Input::get('created')){

			$criteria['created'] = Input::get('created');
		}

		//for title
		if(Input::get('title')){

			$criteria['title'] = Input::get('title');
		}

		//for tip_status
		if(Input::get('status')){

			$criteria['status'] = Input::get('status');
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

		return $this->respondWithData($this->tip->viewClassTips($criteria , $limit, $offset ));
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
