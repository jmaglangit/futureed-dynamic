<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Http\Requests\Api\AdminStudentPointRequest;
use FutureEd\Models\Repository\PointLevel\PointLevelRepositoryInterface;

use Illuminate\Http\Request;

class AdminStudentPointController extends ApiController {

	protected $student;
	protected $point_level;

	public function __construct(StudentRepositoryInterface $student,
								PointLevelRepositoryInterface $point_level){

		$this->student = $student;
		$this->point_level = $point_level;

	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
	public function update($id, AdminStudentPointRequest $request)
	{
		$data = $request->only('points');

		$point_level = $this->point_level->findPointsLevel($data['points']);

		//assign point_level_id
		if($point_level){

			$data['point_level_id'] = $point_level['id'];

		}else{

			$data['point_level_id'] = NULL;
		}

		$this->student->updateStudentDetails($id,$data);

		return $this->respondWithData($this->student->viewStudent($id));
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
