<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\TipRequest;
use FutureEd\Models\Repository\Tip\TipRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\StudentPoint\StudentPointRepositoryInterface;
use FutureEd\Services\RatingService;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class TipController extends ApiController {

	protected $tip;
	protected $student;
	protected $student_points;
	protected $rating_service;

	public function __construct(TipRepositoryInterface $tip
		,StudentRepositoryInterface $student
		,StudentPointRepositoryInterface $student_point
		,RatingService $rating_service){

		$this->tip = $tip;
		$this->student = $student;
		$this->student_point = $student_point;
		$this->rating_service = $rating_service;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 * this will  update the tip_status if verified|rejected
	 */
	public function updateTipStatus($id, TipRequest $request)
	{
		$data = $request->only('tip_status','rated_by','rating');

		//view tip details
		$tip = $this->tip->viewTip($id);

		//check if record is valid
		if(!$tip){
			return $this->respondErrorMessage(2120); //'This record is invalid.'
		}

		//check if tip is already accepted or still pending
		if($tip['tip_status'] != config('futureed.pending')){
			return $this->respondErrorMessage(2150); //'This tip has a rating.'
		}

		//create variables needed for add student points
		$data['points_earned'] = $this->rating_service->getPointsEquivalent($data['rating']);
		$data['student_id'] = $tip['student_id'];
		$data['event_id'] = config('futureed.student_point_description_code_tip');
		$data['description'] = config('futureed.student_point_description_tip');

		//add row to student_points table
		$student_point = $this->student_point->addStudentPoint($data);

		//update points earned on student table
		$student_detail = $this->student->viewStudent($data['student_id']);

		$student_data['points'] = $data['points_earned'] + $student_detail['points'];

		$this->student->updateStudentDetails($data['student_id'], $student_data);

		$this->tip->updateTip($id,$data);

		return $this->respondWithData($this->tip->viewTip($id));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 * this is for student only
	 * view first 3 most recent general tips under a class
	 */

	public function viewCurrentTips(){

		$class_id = NULL;

		//get class_id
		if(Input::get('class_id')){

			$class_id= Input::get('class_id');
		}

		$tip = $this->tip->viewCurrentTips($class_id);

		return $this->respondWithData($tip);

	}






}
