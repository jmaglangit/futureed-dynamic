<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\AnswerExplanation\AnswerExplanationRepositoryInterface;
use Illuminate\Support\Facades\Input;


class AnswerExplanationController extends ApiController {

	protected $answer_explanation;

	public function __construct(
		AnswerExplanationRepositoryInterface $answerExplanationRepositoryInterface
	){
		$this->answer_explanation = $answerExplanationRepositoryInterface;
	}

	/**
	 * Get specific answer explanation.
	 * @return mixed
	 */
	public function getAnswerExplanation(){

		$input = Input::only('module_id','question_id','seq_no');

		return $this->respondWithData($this->answer_explanation->getAnswerExplanation(
			$input['module_id'],
			$input['question_id'],
			$input['seq_no']
		));
	}
}
