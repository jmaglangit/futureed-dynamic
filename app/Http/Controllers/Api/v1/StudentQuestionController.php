<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use FutureEd\Services\QuestionServices;
use Illuminate\Support\Facades\Input;

class StudentQuestionController extends ApiController {

	protected $question;

	protected $question_services;

	public function __construct(
		QuestionRepositoryInterface $question,
		QuestionServices $questionServices
	){

		$this->question = $question;
		$this->question_services = $questionServices;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$criteria = [];
		$limit = 0 ;
		$offset = 0;

		//for module_id
		if(Input::get('module_id')){

			$criteria['module_id'] = Input::get('module_id');
		}

		//for question_type
		if(Input::get('question_type')){

			$criteria['question_type'] = Input::get('question_type');
		}

		//for questions_text
		if(Input::get('questions_text')){

			$criteria['questions_text'] = Input::get('questions_text');
		}

		if(Input::get('questions_id')){
			$criteria['questions_id'] = Input::get('questions_id');
		}

		if(Input::get('last_answered_question_id')){
			$criteria['last_answered_question_id'] = Input::get('last_answered_question_id');
		}

		if(Input::get('difficulty')){
			$criteria['difficulty'] = Input::get('difficulty');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}
		$question = $this->question->getQuestions($criteria , $limit, $offset );

		foreach($question['records'] as $k => $v){

			unset($question['records'][$k]['answer']);

			foreach($question['records'][$k]['question_answers'] as $key => $value){

				unset($question['records'][$k]['question_answers'][$key]['correct_answer']);

				unset($question['records'][$k]['question_answers'][$key]['point_equivalent']);

			}
		}


		return $this->respondWithData($question);

	}

	/**
	 * Get Graph Questions.
	 * @param $id
	 * @param StudentQuestionRequest $request
	 * @return mixed
	 */
	public function graph($id){

		$graph = $this->question->getGraphQuestion($id);

		if (!empty($graph)) {
			$answer = $this->question->getQuestionAnswer($graph->id);

			$question_answers = json_decode($answer);

			//Get dimension	of each graph.
			if ($graph->question_type == config('futureed.question_type_graph')) {
				$graph->dimension = $this->question_services->getGraphDimension($question_answers->answer);
			}

			if ($graph->question_type == config('futureed.question_type_quad')) {
				$graph->dimension = $this->question_services->getQuadDimension($question_answers->answer);
			}

			unset($graph->answer);
		}

		return $this->respondWithData($graph);

	}
}
