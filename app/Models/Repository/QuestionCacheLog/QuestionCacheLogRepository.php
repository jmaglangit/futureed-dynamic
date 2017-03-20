<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/17
 * Time: 2:29 PM
 */

namespace FutureEd\Models\Repository\QuestionCacheLog;


use FutureEd\Models\Core\QuestionCacheLog;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class QuestionCacheLogRepository implements QuestionCacheLogRepositoryInterface{

	use LoggerTrait;


	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getQuestionCacheLogs($criteria=[],$limit=0,$offset=0){

		$question_cache_log = new QuestionCacheLog();

		if(isset($criteria['user_id'])){
			$question_cache_log = $question_cache_log->userId($criteria['user_id']);
		}

		if(isset($criteria['description'])){
			$question_cache_log = $question_cache_log->description($criteria['description']);
		}

		if(isset($criteria['status'])){
			$question_cache_log = $question_cache_log->status($criteria['status']);
		}

		$count = $question_cache_log->count();

		if ($offset >= 0 && $limit > 0) {

			$question_cache_log = $question_cache_log->skip($offset)->take($limit);
		}

		return [
			'total' => $count,
			'records' => $question_cache_log->get()
		];
	}

	/**
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getQuestionCacheLog($id){

		return QuestionCacheLog::find($id);
	}

	/**
	 * @param $data
	 * @return bool|static
	 */
	public function addQuestionCacheLog($data){

		DB::begintransaction();

		try{

			$response = QuestionCacheLog::create($data);

		} catch(\Exception $e){

			DB::rollblack();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @param $data
	 * @return bool|int
	 */
	public function updateQuestionCacheLog($id,$data){

		DB::beginTransaction();
		try{

			$response = QuestionCacheLog::find($id)->update($data);

		} catch(\Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @return bool|null
	 */
	public function deleteQuestionCacheLog($id){

		DB::beginTransaction();

		try{

			$response = QuestionCacheLog::find($id)->delete();

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}
}