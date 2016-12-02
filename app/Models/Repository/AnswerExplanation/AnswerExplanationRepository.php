<?php namespace FutureEd\Models\Repository\AnswerExplanation;

use FutureEd\Models\Core\AnswerExplanation;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class AnswerExplanationRepository implements  AnswerExplanationRepositoryInterface{

	use LoggerTrait;
	/**
	 * Get specefic answer explanation.
	 * @param $module_id
	 * @param $question_id
	 * @return mixed
	 * @internal param $seq_no
	 */
	public function getAnswerExplanation($module_id, $question_id){

		return AnswerExplanation::moduleId($module_id)
			->questionId($question_id)
			->get();
	}

	/**
	* Get specific answer explanation
	* @param $question_id
	* @return mixed
	*/
	public function getAnswerExplanationByQuestionId($question_id){

		return AnswerExplanation::questionId($question_id)
			->get();
	}

	/**
	 * Update answer explanation.
	 * @param $id
	 * @param $data
	 * @return bool|int
	 */
	public function updateAnswerExplanation($id,$data){

		DB::beginTransaction();

		try{

			$response = AnswerExplanation::find($id)->update($data);
		} catch(\Exception $e){

			$this->errorLog($e->getMessage());

			DB::rollback();

			return false;
		}

		DB::commit();

		return $response;
	}
}