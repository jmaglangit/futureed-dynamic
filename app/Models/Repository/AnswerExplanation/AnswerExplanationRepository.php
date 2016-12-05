<?php namespace FutureEd\Models\Repository\AnswerExplanation;

use FutureEd\Models\Core\AnswerExplanation;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class AnswerExplanationRepository implements  AnswerExplanationRepositoryInterface{

	use LoggerTrait;

	public function getAnswerExplanation($criteria, $limit = 0, $offset = 0){

		DB::beginTransaction();
		try{
			$answer_explanation = new AnswerExplanation();

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $answer_explanation->count();

			} else {
				if(count($criteria) > 0){
					if(isset($criteria['question_id'])){

						$answer_explanation = $answer_explanation->questionId($criteria['question_id']);
					}

					if(isset($criteria['module_id'])){

						$answer_explanation = $answer_explanation->moduleId($criteria['module_id']);
					}

				}

				$count = $answer_explanation->count();

				if ($limit > 0 && $offset >= 0) {
					$answer_explanation = $answer_explanation->offset($offset)->limit($limit);
				}

				$records = $answer_explanation->get()->toArray();


				$response = ['total' => $count, 'records' => $records];
			}
		} catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

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