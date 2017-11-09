<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\HelpRequestAnswer\HelpRequestAnswerRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\StudentPoint\StudentPointRepositoryInterface;
use FutureEd\Http\Requests\Api\HelpRequestAnswerStatusRequest;
use FutureEd\Services\RatingService;
use Illuminate\Support\Facades\Input;

class HelpRequestAnswerStatusController extends ApiController {

	protected $help_request_answer;
	protected $student;
	protected $student_points;
	protected $rating_service;

	/**
	 * Initialized
	 * @param HelpRequestAnswerRepositoryInterface $helpRequestAnswerRepositoryInterface
	 */
	public function __construct(
		HelpRequestAnswerRepositoryInterface $helpRequestAnswerRepositoryInterface
		,StudentRepositoryInterface $student
		,StudentPointRepositoryInterface $student_point
		,RatingService $rating_service
	){
		$this->help_request_answer = $helpRequestAnswerRepositoryInterface;
		$this->student = $student;
		$this->student_point = $student_point;
		$this->rating_service = $rating_service;
	}

	/**
	 * Update status
	 * @param HelpRequestAnswerStatusRequest $request
	 * @param $id
	 * @return mixed
	 */
	public function updateStatus(HelpRequestAnswerStatusRequest $request, $id){
		$data  = $request->only('request_answer_status','rated_by','rating');

		//get help request details
		$help_request_answer = $this->help_request_answer->getHelpRequestAnswer($id);

		if($help_request_answer['request_answer_status'] != config('futureed.pending')){
			return $this->respondErrorMessage(2151); //'This help answer has an existing rating'
		}

		//create variables needed for add student points
		$data['points_earned'] = $this->rating_service->getPointsEquivalent($data['rating']);
		$data['student_id'] = $help_request_answer['student_id'];
		$data['event_id'] = config('futureed.student_point_description_code_help');
		$data['description'] = config('futureed.student_point_description_help');

		//add row to student_points table
		$student_point = $this->student_point->addStudentPoint($data);

		//update points earned on student table
		$student_detail = $this->student->viewStudent($data['student_id']);

		$student_data['points'] = $data['points_earned'] + $student_detail['points'];

		$this->student->updateStudentDetails($data['student_id'], $student_data);

		$this->help_request_answer->updateHelpRequestAnswer($id, $data);

		return $this->respondWithData($this->help_request_answer->getHelpRequestAnswer($id));


	}

}
