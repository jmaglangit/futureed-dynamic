<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\TipRequest;
use FutureEd\Models\Repository\Tip\TipRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\StudentPoint\StudentPointRepositoryInterface;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class TipController extends ApiController {

	protected $tip;
	protected $student;
	protected $student_points;

	public function __construct(TipRepositoryInterface $tip
		,StudentRepositoryInterface $student
		,StudentPointRepositoryInterface $student_point){

		$this->tip = $tip;
		$this->student = $student;
		$this->student_point = $student_point;
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
		//$data = $request->only('tip_status','rated_by','rating');

		$data = $request->all();

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
		$data['points_earned'] = $this->getPointsEquivalent($data['rating']);
		$data['student_id'] = $tip['student_id'];
		$data['event_id'] = config('futureed.student_point_description_tip_code');
		$data['description'] = config('futureed.student_point_description_tip_desc');

		//add row to student_points table
		$student_point = $this->student_point->addStudentPoint($data);

		//update points earned on student table
		$student_detail = $this->student->viewStudent($data['student_id']);

		$student_data['points'] = $data['points_earned'] + $student_detail['points'];

		$this->student->updateStudentDetails($data['student_id'], $student_data);

		$this->tip->updateTip($id,$data);

		return $this->respondWithData($this->tip->viewTip($id));

	}

	private function getPointsEquivalent($rating){
		switch ($rating) {
			case 1:
				return 4;
				break;

			case 2:
				return 8;
				break;

			case 3:
				return 12;
				break;

			case 4:
				return 16;
				break;

			case 5:
				return 20;
				break;

			default:
				return 0;
				break;
		}
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
