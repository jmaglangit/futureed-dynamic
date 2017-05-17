<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\QuestionCacheLogRequest;
use FutureEd\Models\Repository\QuestionCacheLog\QuestionCacheLogRepositoryInterface;
use Illuminate\Support\Facades\Input;

class QuestionCacheLogController extends ApiController {

	protected $question_cache_log;

	public function __construct(
		QuestionCacheLogRepositoryInterface $questionCacheLogRepositoryInterface
	){
		$this->question_cache_log = $questionCacheLogRepositoryInterface;
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

		//'user_id',
		if(Input::get('user_id')){
			$criteria['user_id'] = Input::get('user_id');
		}

		//'description',
		if(Input::get('description')){
			$criteria['description'] = Input::get('description');
		}

		//'status'
		if(Input::get('status')){
			$criteria['status'] = Input::get('status');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->question_cache_log->getQuestionCacheLogs($criteria,$limit,$offset));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param QuestionCacheLogRequest $request
	 * @return Response
	 */
	public function store(QuestionCacheLogRequest $request)
	{
		return $this->respondWithData($this->question_cache_log->addQuestionCacheLog($request->all()));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->question_cache_log->getQuestionCacheLog($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param QuestionCacheLogRequest $request
	 * @return Response
	 */
	public function update($id,QuestionCacheLogRequest $request)
	{
		return $this->respondWithData($this->question_cache_log->updateQuestionCacheLog($id,$request->all()));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return $this->respondWithData($this->question_cache_log->deleteQuestionCacheLog($id));
	}

}
