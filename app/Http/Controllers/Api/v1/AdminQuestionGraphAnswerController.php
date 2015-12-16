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

	//get graph answer and update question table
	// this is to update each answer.
	public function UpdateGraphAnswer($id,AdminQuestionGraphAnswerRequest $request){

		$question = $this->question->getGraphQuestion($id);

		$answer = $request->get('answer');

		if(empty($question->toArray())){

			return $this->respondErrorMessage(2120);
		}

		//check if answer has correct format.
		//if confirmed save answer else return error.

		$this->question_service->checkGraphAnswerContent($answer);




	}

}
