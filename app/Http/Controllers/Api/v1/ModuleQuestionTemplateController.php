<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\ModuleQuestionTemplateRequest;
use FutureEd\Models\Repository\ModuleQuestionTemplate\ModuleQuestionTemplateRepositoryInterface;
use Illuminate\Support\Facades\Input;

class ModuleQuestionController extends ApiController {

	protected $module_question_template;

	public function __construct(
		ModuleQuestionTemplateRepositoryInterface $moduleQuestionTemplateRepositoryInterface
	){
		$this->module_question_template = $moduleQuestionTemplateRepositoryInterface;
	}

	/**
	 * @return mixed
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0;
		$offset = 0;

		if(Input::get('question_template_id')){
			$criteria['question_template_id'] = Input::get('question_template_id');
		}

		if(Input::get('template')){
			$criteria['template'] = Input::get('template');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->module_question_template->getModuleQuestionTemplates($criteria,$limit,$offset));
	}

	/**
	 * @param ModuleQuestionTemplateRequest $request
	 * @return mixed
	 */
	public function store(ModuleQuestionTemplateRequest $request)
	{
		return $this->respondWithData($this->module_question_template->addModuleQuestionTemplate($request->all()));
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function show($id)
	{
		return $this->respondWithData($this->module_question_template->getModuleQuestionTemplate($id));
	}

	/**
	 * @param $id
	 * @param ModuleQuestionTemplateRequest $request
	 * @return mixed
	 */
	public function update($id,ModuleQuestionTemplateRequest $request)
	{
		return $this->respondWithData($this->module_question_template->updateModuleQuestionTemplate($id,$request->all()));
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function destroy($id)
	{
		return $this->respondWithData($this->module_question_template->deleteModuleQuestionTemplate($id));
	}

}
