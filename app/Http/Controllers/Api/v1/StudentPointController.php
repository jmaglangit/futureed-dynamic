<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\StudentPoint\StudentPointRepositoryInterface;
use Illuminate\Support\Facades\Input;
use FutureEd\Http\Requests\Api\StudentPointRequest;


use Illuminate\Http\Request;

class StudentPointController extends ApiController {

	protected $student_point;

	public function __construct(StudentPointRepositoryInterface $student_point){

		$this->student_point = $student_point;

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

		//for student_id
		if(Input::get('student_id')){

			$criteria['student_id'] = Input::get('student_id');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		//get Student Points
		return $this->respondWithData($this->student_point->getStudentPoints($criteria , $limit, $offset ));
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
		return $this->respondWithData($this->student_point->viewStudentPoint($id));
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
	public function update($id, StudentPointRequest $request)
	{
		$data = $request->only('event_id','points_earned','description');

		$this->student_point->updateStudentPoint($id,$data);

		return $this->respondWithData($this->student_point->viewStudentPoint($id));
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
