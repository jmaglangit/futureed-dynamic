<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 4/4/17
 * Time: 9:10 PM
 */

namespace FutureEd\Models\Repository\QuestionTemplateOperation;

use FutureEd\Models\Core\QuestionTemplateOperation;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class QuestionTemplateOperationRepository implements QuestionTemplateOperationRepositoryInterface{

	use LoggerTrait;

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getQuestionTemplateOperations($criteria = [],$limit = 0,$offset = 0){

		$operation = new QuestionTemplateOperation();

		if(isset($criteria['operation_data'])){
			$operation = $operation->operationData($criteria['operation_data']);
		}

		if(isset($criteria['status'])){
			$operation = $operation->status($criteria['status']);
		}

		$count = $operation->count();

		if ($limit > 0 && $offset >= 0) {
			$operation = $operation->offset($offset)->limit($limit);
		}

		$response = ['total' => $count, 'records' => $operation->get()->toArray()];

		return $response;
	}

	/**
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getQuestionTemplateOperation($id) {

		return QuestionTemplateOperation::find($id);
	}

	/**
	 * @param $data
	 * @return bool|static
	 */
	public function addQuestionTemplateOperation($data) {

		DB::beginTransaction();

		try{

			$response = QuestionTemplateOperation::create($data);

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
	public function editQuestionTemplateOperation($id, $data) {

		DB::beginTransaction();

		try{

			$response = QuestionTemplateOperation::find($id)->update($data);

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
	public function deleteQuestionTemplateOperation($id) {

		DB::beginTransaction();

		try{

			$response = QuestionTemplateOperation::find($id)->delete();

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	public function getOperationByData($data){

		return QuestionTemplateOperation::where('operation_data',$data)->get()->first();
	}
}