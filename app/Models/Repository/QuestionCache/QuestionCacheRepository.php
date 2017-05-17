<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/17
 * Time: 2:01 PM
 */

namespace FutureEd\Models\Repository\QuestionCache;


use FutureEd\Models\Core\QuestionCache;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class QuestionCacheRepository implements QuestionCacheRepositoryInterface{

	use LoggerTrait;

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getQuestionCaches($criteria=[],$limit=0,$offset=0){

		$question_cache = new QuestionCache();

		$question_cache = $question_cache->with('questionTemplate','moduleQuestionTemplate');



		if(isset($criteria['module_question_template_id'])){
			$question_cache = $question_cache->moduleQuestionTemplateId($criteria['module_question_template_id']);
		}

		if(isset($criteria['question_template_id'])){
			$question_cache = $question_cache->questionTemplateId($criteria['question_template_id']);
		}

		if(isset($criteria['question_text'])){
			$question_cache = $question_cache->questionText($criteria['question_text']);
		}

		$count = $question_cache->count();

		if ($offset >= 0 && $limit > 0) {

			$question_cache = $question_cache->skip($offset)->take($limit);
		}

		return [
			'total' => $count,
			'records' => $question_cache->get()
		];
	}

	/**
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getQuestionCache($id){

		return QuestionCache::with('questionTemplate')->find($id);
	}

	/**
	 * @param $module_question_id
	 * @param $question_template_id
	 * @return mixed
	 */
	public function getModuleTemplate($module_question_id,$question_template_id){

		//get module_question_id, and question_template_id

		return QuestionCache::moduleQuestionTemplateId($module_question_id)
			->questionTemplateId($question_template_id)->first();
	}

	/**
	 * @param $data
	 * @return bool|static
	 */
	public function addQuestionCache($data){

		DB::beginTransaction();

		try{
			
			$response = QuestionCache::create($data);

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
	 * @param $data
	 * @return bool|int
	 */
	public function updateQuestionCache($id,$data){

		DB::beginTransaction();
		try{

			$response = QuestionCache::find($id)->update($data);

		} catch (\Exception $e){

			DB::rolback();

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
	public function deleteQuestionCache($id){

		DB::beginTransaction();
		try{

			$response = QuestionCache::find($id)->delete();;

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}