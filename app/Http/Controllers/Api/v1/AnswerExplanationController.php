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

		$input = Input::only('module_id','question_id','limit','offset');

		$limit = 0 ;

		$offset = 0;

		if(isset($input['limit'])){

			$limit = intval($input['limit']);
		}

		if(isset($input['offset'])){

			$offset = intval($input['offset']);
		}

		if (isset($input['module_id'])) {

			$criteria['module_id'] = $input['module_id'];
		}

		if(isset($input['question_id'])){

			$criteria['question_id'] = $input['question_id'];
		}

		$result = $this->answer_explanation->getAnswerExplanation($criteria,$limit, $offset);

		return $this->respondWithData($result);
	}
}
