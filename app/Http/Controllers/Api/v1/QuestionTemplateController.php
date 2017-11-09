<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\QuestionTemplateRequest;
use FutureEd\Models\Repository\QuestionTemplate\QuestionTemplateRepositoryInterface;
use FutureEd\Models\Repository\QuestionTemplateExplanation\QuestionTemplateExplanationRepositoryInterface;
use FutureEd\Models\Repository\QuestionTemplateOperation\QuestionTemplateOperationRepositoryInterface;
use Illuminate\Support\Facades\Input;
use FutureEd\Services\QuestionTemplateServices;

class QuestionTemplateController extends ApiController {

	protected $question_template;

	protected $question_template_operation;

	protected $question_template_explanation;

	protected $question_temp_operation_service;

	/**
	 * @param QuestionTemplateRepositoryInterface $questionTemplateRepositoryInterface
	 * @param QuestionTemplateOperationRepositoryInterface $questionTemplateOperationRepositoryInterface
	 * @param QuestionTemplateExplanationRepositoryInterface $questionTemplateExplanationRepositoryInterface
	 */
	public function __construct(
		QuestionTemplateRepositoryInterface $questionTemplateRepositoryInterface,
		QuestionTemplateOperationRepositoryInterface $questionTemplateOperationRepositoryInterface,
		QuestionTemplateExplanationRepositoryInterface $questionTemplateExplanationRepositoryInterface,
		QuestionTemplateServices $questionTemplateServices
	){
		$this->question_template = $questionTemplateRepositoryInterface;
		$this->question_template_operation = $questionTemplateOperationRepositoryInterface;
		$this->question_template_explanation = $questionTemplateExplanationRepositoryInterface;
		$this->question_temp_operation_service = $questionTemplateServices;
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

		//question_form
		if(Input::get('question_form')){
			$criteria['question_form'] = Input::get('question_form');
		}

		//operation
		if(Input::get('operation')){
			//filter operation
			$operations = $this->question_template_operation->getOperationByData(Input::get('operation'));

			$criteria['operation'] = $operations->id;
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
	 * @return \Symfony\Component\HttpFoundation\Response
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

		//check operation variables used if exist
		$check_operation_var = $this->question_temp_operation_service->checkOperationVariables($question_template);

		//change filter of operation into id
		$operations = $this->question_template_operation->getOperationByData($request->only('operation'));
		$question_template['operation'] = $operations->id;

		if($check_operation_var){
			if($check_operation_var == config('futureed.true')){
				$template = $this->question_template->addQuestionTemplate($question_template);
				return $this->respondWithData($template);
			}else{
				return $this->respondWithError([
					'error_code' => 2605,
					'message' => $check_operation_var['message']
				]);
			}
		}
		//add question_template_explanation
		$explanation = $this->question_template_explanation->addQuestionTemplateExplanation([
			'question_template_id' => $template->id,
			'explanation' => $request->get('question_template_explanation')
		]);

		// $template->question_template_tips = $explanation->explanation;

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
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function update($id, QuestionTemplateRequest $request)
	{
		$question_template = $request->only([
			'equation_type',
			'question_template_format',
			'question_equation',
			'operation',
			'status'
		]);

		$explanation_request = $request->get('question_template_explanation');

		$explanation = $this->question_template_explanation->updateQuestionTemplateExplanationByTemplateId($id,[
			'explanation' => $explanation_request['explanation']
		]);

		//check operation variables used if exist
		$check_operation_var = $this->question_temp_operation_service->checkOperationVariables($question_template);

		//change filter of operation into id
		$operations = $this->question_template_operation->getOperationByData($request->only('operation'));
		$question_template['operation'] = $operations->id;

		if($check_operation_var){
			if($check_operation_var == config('futureed.true')){
				//update question template by question_template_id
				$this->question_template->updateQuestionTemplate($id,$question_template);

				$question_template = $this->question_template->getQuestionTemplate($id);
				return $this->respondWithData($question_template);
			}else{
				return $this->respondWithError([
					'error_code' => 2605,
					'message' => $check_operation_var['message']
				]);
			}
		}
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
