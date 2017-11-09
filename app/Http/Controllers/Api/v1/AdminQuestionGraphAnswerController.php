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
	public function updateGraphAnswer($id,AdminQuestionGraphAnswerRequest $request){

		$question = $this->question->getGraphQuestionByType($id, $request->get('question_type'));

		if($question == NULL){

			return $this->respondErrorMessage(2120);
		}

		$answer = $request->get('answer');
		$question_type = $request->get('question_type');

		//check graph if GR
		if($question_type == config('futureed.question_type_graph')){

			$graph = $this->question_service->graphImageFileTransfer($id,$answer);

			//update image content
			$question_graph_content = $this->question_service->updateGraphContentImage($question->question_graph_content,$graph['content']);

			return $this->respondWithData(
				$this->question->updateQuestion(
					$id,[
						'answer'=>$graph['answer'],
						'question_graph_content' => $question_graph_content
					]
				)
			);
		}

		return $this->respondWithData($this->question->updateQuestion($id,['answer'=>$answer]));
	}

	/**
	 * Gets the answers of the GRAPH question type
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function getGraphAnswer($id){
		return $this->respondWithData($this->question->getQuestionAnswer($id));
	}

}
