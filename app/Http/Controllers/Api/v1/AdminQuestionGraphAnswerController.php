<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use FutureEd\Services\QuestionServices;
use FutureEd\Http\Requests\Api\AdminQuestionGraphAnswerRequest;

class AdminQuestionGraphAnswerController extends ApiController {

	protected $question;

	protected $question_service;

	public function __construct(
		QuestionRepositoryInterface $questionRepositoryInterface,
		QuestionServices $questionServices
	){
		$this->question = $questionRepositoryInterface;
		$this->question_service = $questionServices;
	}

	/**
	 * Get Graph answers and update question table answer.
	 * @param $id
	 * @param AdminQuestionGraphAnswerRequest $request
	 * @return mixed
	 */
	public function UpdateGraphAnswer($id,AdminQuestionGraphAnswerRequest $request){

		$question = $this->question->getGraphQuestion($id);

		$answer = $request->get('answer');

		if(empty($question->toArray())){

			return $this->respondErrorMessage(2120);
		}

		//if confirmed save answer else return error.
		return $this->respondWithData($this->question->updateQuestion($id,['answer'=>$answer]));
	}

}
