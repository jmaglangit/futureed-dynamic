<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\QuestionTemplateRequest;
use FutureEd\Models\Repository\QuestionTemplate\QuestionTemplateRepositoryInterface;
use FutureEd\Models\Repository\QuestionTemplateOperation\QuestionTemplateOperationRepositoryInterface;
use Illuminate\Support\Facades\Input;

class QuestionTemplateController extends ApiController {

	protected $question_template;

	protected $question_template_operation;

	/**
	 * @param QuestionTemplateRepositoryInterface $questionTemplateRepositoryInterface
	 * @param QuestionTemplateOperationRepositoryInterface $questionTemplateOperationRepositoryInterface
	 */
	public function __construct(
		QuestionTemplateRepositoryInterface $questionTemplateRepositoryInterface,
		QuestionTemplateOperationRepositoryInterface $questionTemplateOperationRepositoryInterface
	){
		$this->question_template = $questionTemplateRepositoryInterface;
		$this->question_template_operation = $questionTemplateOperationRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param QuestionTemplateRequest $request
	 * @return Response
	 * @internal param QuestionTemplateRequest $questionTemplateRequest
	 */
	public function index()
	{
		$criteria = [];

		//equation_type
		if(Input::get('question_type')){
			$criteria['question_type'] = Input::get('question_type');
		}

		//question template format
		if(Input::get('question_template_format')){
			$criteria['question_template_format'] = Input::get('question_template_format');
		}

		//question_equation
		if(Input::get('question_equation')){
			$criteria['question_equation'] = Input::get('question_equation');
		}

		//operation
		if(Input::get('operation')){
			$criteria['operation'] = Input::get('operation');
		}

		//status
		if(Input::get('status')){
			$criteria['status'] = Input::get('status');
		}

		$limit = (Input::get('limit')) ? Input::get('limit') : 0;

		$offset = (Input::get('offset')) ? Input::get('offset') : 0;


		return $this->respondWithData($this->question_template->getQuestionTemplates($criteria,$limit,$offset));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param QuestionTemplateRequest $request
	 */
	public function store(QuestionTemplateRequest $request)
	{
		$question_template = $request->only([
			'question_type',
			'question_template_format',
			'question_equation',
			'operation',
			'question_form'
		]);


		//change filter of operation into id
		$operations = $this->question_template_operation->getOperationByData($request->only('operation'));

		$question_template['operation'] = $operations->id;

		return $this->respondWithData($this->question_template->addQuestionTemplate($question_template));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->question_template->getQuestionTemplate($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param QuestionTemplateRequest $request
	 */
	public function update($id, QuestionTemplateRequest $request)
	{
		$question_template = $request->only([
			'equation_type',
			'question_template_format',
			'question_equation',
			'status'
		]);

		return $this->respondWithData($this->question_template->updateQuestionTemplate($id,$question_template));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return $this->respondWithData($this->question_template->deleteQuestionTemplate($id));
	}

}
