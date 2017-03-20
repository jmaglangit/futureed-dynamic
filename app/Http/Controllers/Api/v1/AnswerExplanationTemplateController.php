<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\AdminAnswerExplanationTemplateRequest;
use FutureEd\Models\Repository\AnswerExplanationTemplate\AnswerExplanationTemplateRepositoryInterface;
use Illuminate\Support\Facades\Input;

class AnswerExplanationTemplateController extends ApiController {

	protected $answer_explanation_template;

	public function __construct(
		AnswerExplanationTemplateRepositoryInterface $answerExplanationTemplateRepositoryInterface
	){
		$this->answer_explanation_template = $answerExplanationTemplateRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0;
		$offset = 0;

		//module_id
		if(Input::get('module_id')){
			$criteria['module_id']= Input::get('module_id');
		}

		//question_template_id
		if(Input::get('question_template_id')){
			$criteria['question_template_id'] = Input::get('question_template_id');
		}

		//status
		if(Input::get('status')){
			$criteria['status'] = Input::get('status');
		}

		return $this->respondWithData($this->answer_explanation_template->getAnswerExplanationTemplates($criteria,$limit,$offset));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param AdminAnswerExplanationTemplateRequest $request
	 * @return Response
	 */
	public function store(AdminAnswerExplanationTemplateRequest $request)
	{
		return $this->respondWithData($this->answer_explanation_template->addAnswerExplanationTemplate($request->all()));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->answer_explanation_template->getAnswerExplanationTemplate($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param AdminAnswerExplanationTemplateRequest $request
	 * @return Response
	 */
	public function update($id, AdminAnswerExplanationTemplateRequest $request)
	{
		return $this->respondWithData($this->answer_explanation_template->updateAnswerExplanationTemplate($id,$request->all()));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return $this->respondWithData($this->answer_explanation_template->deleteAnswerExplanationTemplate($id));
	}

}
