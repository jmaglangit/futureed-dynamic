<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Http\Requests\Api\QuestionCacheRequest;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\QuestionCache\QuestionCacheRepositoryInterface;
use FutureEd\Models\Repository\QuestionTemplateOperation\QuestionTemplateOperationRepositoryInterface;
use FutureEd\Services\QuestionCacheServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class QuestionCacheController extends ApiController {

	protected $question_cache;

	protected $question_cache_service;

	protected $question_template_operation;

	protected $module;

	/**
	 * QuestionCacheController constructor.
	 * @param QuestionCacheRepositoryInterface $questionCacheRepositoryInterface
	 * @param QuestionCacheServices $questionCacheServices
	 * @param ModuleRepositoryInterface $moduleRepositoryInterface
	 * @param QuestionTemplateOperationRepositoryInterface $questionTemplateOperationRepository
	 * @internal param $QuestionTemplateOperationRepositoryInterface $
	 */
	public function __construct(
		QuestionCacheRepositoryInterface $questionCacheRepositoryInterface,
		QuestionCacheServices $questionCacheServices,
		ModuleRepositoryInterface $moduleRepositoryInterface,
		QuestionTemplateOperationRepositoryInterface $questionTemplateOperationRepository
	){
		$this->question_cache = $questionCacheRepositoryInterface;
		$this->question_cache_service = $questionCacheServices;
		$this->module = $moduleRepositoryInterface;
		$this->question_template_operation = $questionTemplateOperationRepository;
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

		if(Input::get('module_question_template_id')){
			$criteria['module_question_tempalte_id'] = Input::get('module_question_template_id');
		}

		if(Input::get('question_template_id')){
			$criteria['question_template_id'] = Input::get('question_template_id');
		}

		if(Input::get('question_text')){
			$criteria['question_text'] = Input::get('question_text');
		}

		if(Input::get('status')){
			$criteria['status'] = Input::get('status');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->question_cache->getQuestionCaches($criteria,$limit,$offset));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param QuestionCacheRequest $request
	 */
	public function store(QuestionCacheRequest $request)
	{
		return $this->respondWithData($this->question_cache->addQuestionCache($request->all()));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->question_cache->getQuestionCache($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param QuestionCacheRequest $request
	 */
	public function update($id,QuestionCacheRequest $request)
	{
		return $this->respondWithData($this->question_cache->updateQuestionCache($id,$request->all()));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return $this->respondWithData($this->question_cache->deleteQuestionCache($id));
	}

	public function generationQuestions(){

		if(Input::get('module_id')){
			//generate individual module
			$this->question_cache_service->generateQuestions(Input::get('module_id'));

		} else {
			//generate all modules

			//get all dynamic modules and parse
			$dynamic_modules = $this->module->getDynamicModules();

			//generate questions on every module
			foreach($dynamic_modules as $module){

				$this->question_cache_service->generateQuestions($module->id);
			}
		}

		return $this->respondWithData(true);
	}


	public function previewQuestion(){

		//operation
			//filter operation

		//question template and attributes
		$question = $this->question_cache_service->generatePreviewQuestion(Input::get('question_template_format'),
			[
				'operation' => Input::get('operation'),
				'question_form' => Input::get('question_form')
			]);

		return $this->respondWithData($question);
	}
}
