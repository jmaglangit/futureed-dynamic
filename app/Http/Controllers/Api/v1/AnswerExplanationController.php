<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\AnswerExplanation\AnswerExplanationRepositoryInterface;
use Illuminate\Support\Facades\Input;
use FutureEd\Services\ImageServices;


class AnswerExplanationController extends ApiController {

	protected $answer_explanation;

	protected $image_service;

	public function __construct(
		AnswerExplanationRepositoryInterface $answerExplanationRepositoryInterface,
		ImageServices $image_service
	){
		$this->answer_explanation = $answerExplanationRepositoryInterface;
		$this->image_service = $image_service;
	}

	/**
	 * Get specific answer explanation.
	 * @return mixed
	 */
	public function getAnswerExplanation(){

		$input = Input::only('module_id','question_id');

		$result = $this->answer_explanation->getAnswerExplanation(
			$input['module_id'],
			$input['question_id']
		);

		foreach ($result as $key) {

			if (!empty($key->image)) {

				$key->image = $this->image_service->getAnswerExplanationImage($key->image);
			}
		}

		return $this->respondWithData($result);
	}
}
