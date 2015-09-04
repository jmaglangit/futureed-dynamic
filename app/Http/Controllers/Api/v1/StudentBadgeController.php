<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use FutureEd\Models\Repository\StudentBadge\StudentBadgeRepositoryInterface;
use FutureEd\Http\Requests\Api\StudentBadgeRequest;

class StudentBadgeController extends ApiController {

	protected $student_badge;

	public function __construct(StudentBadgeRepositoryInterface $student_badge){

		$this->student_badge = $student_badge;

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

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->student_badge->getStudentBadges($criteria , $limit, $offset ));

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$student_badge = $this->student_badge->viewStudentBadge($id);

		return $this->respondWithData($student_badge);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, StudentBadgeRequest $request)
	{
		$data = $request->only('badge_id');

		$this->student_badge->updateStudentBadge($id,$data);

		return $this->respondWithData($this->student_badge->viewStudentBadge($id));


	}

}
