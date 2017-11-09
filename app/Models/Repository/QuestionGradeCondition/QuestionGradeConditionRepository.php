<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 4/4/17
 * Time: 9:08 PM
 */

namespace FutureEd\Models\Repository\QuestionGradeCondition;


use FutureEd\Models\Core\QuestionGradeCondition;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class QuestionGradeConditionRepository implements QuestionGradeConditionRepositoryInterface{

	use LoggerTrait;

	/**
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getQuestionGradeCondition($id){

		return QuestionGradeCondition::find($id);
	}

	/**
	 * @param $grade_id
	 * @return mixed
	 */
	public function getGradeId($grade_id){

		return QuestionGradeCondition::whereGradeId($grade_id)->first();
	}

	/**
	 * @param $data
	 * @return bool|static
	 */
	public function addQuestionGradeCondition($data){

		DB::beginTransaction();

		try{

			$response = QuestionGradeCondition::create($data);

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
	public function editQuestionGradeCondition($id,$data){

		DB::beginTransaction();

		try{

			$response = QuestionGradeCondition::find($id)->update($data);

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
	public function deleteQuestionGradeCondition($id){

		DB::beginTransaction();

		try{

			$response = QuestionGradeCondition::find($id)->delete();

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}