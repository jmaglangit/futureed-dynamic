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