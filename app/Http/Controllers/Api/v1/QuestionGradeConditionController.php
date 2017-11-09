<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\QuestionGradeCondition\QuestionGradeConditionRepositoryInterface;
use Illuminate\Http\Request;

class QuestionGradeConditionController extends ApiController {

	protected $grade_condition;

	/**
	 * QuestionGradeConditionController constructor.
	 * @param QuestionGradeConditionRepositoryInterface $questionGradeConditionRepositoryInterface
	 */
	public function __construct(
		QuestionGradeConditionRepositoryInterface $questionGradeConditionRepositoryInterface
	){
		$this->grade_condition = $questionGradeConditionRepositoryInterface;
	}

	/**
	 * @param int $grade_id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getConditionByGradeId($grade_id = 0){

			return $this->respondWithData($this->grade_condition->getGradeId($grade_id));
	}

}
