<?php

namespace FutureEd\Models\Repository\QuestionAnswer;

use FutureEd\Models\Core\QuestionAnswer;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Session;

class QuestionAnswerRepository implements QuestionAnswerRepositoryInterface{

	use LoggerTrait;
	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addQuestionAnswer($data){

		DB::beginTransaction();

		try {

			$question_answer = QuestionAnswer::create($data);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $question_answer;
	}

	/**
	 * Gets list of QuestionAnswers.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getQuestionAnswers($criteria = array(), $limit = 0, $offset = 0){

		DB::beginTransaction();

		try {
			session(['super_access' => 1]);
			$question_answer = new QuestionAnswer();

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $question_answer->count();

			} else {


				if (count($criteria) > 0) {

					//for question_id
					if (isset($criteria['question_id'])) {

						$question_answer = $question_answer->questionId($criteria['question_id']);

					}

				}

				$count = $question_answer->count();

				if ($limit > 0 && $offset >= 0) {
					$question_answer = $question_answer->offset($offset)->limit($limit);
				}

			}

			$records = $question_answer->get()->toArray();

			Session::forget('super_access');

			$response = ['total' => $count, 'records' => $records];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get a record on QuestionAnswer.
	 * @param $id
	 * @return mixed
	 */
	public function viewQuestionAnswer($id){

		DB::beginTransaction();

		try {
			$question_answer = new QuestionAnswer();

			$question_answer = $question_answer->find($id);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $question_answer;
	}


	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */
	public function updateQuestionAnswer($id,$data){

		DB::beginTransaction();

		try{

			$response = QuestionAnswer::find($id)
				->update($data);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Delete a record.
	 * @param $id
	 * @return bool|null|string
	 * @throws \Exception
	 */
	public function deleteQuestionAnswer($id){

		DB::beginTransaction();

		try{

			$response = QuestionAnswer::find($id)
				->delete();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

    /**
     * Get correct answer from question.
     * @param $question_id
     * @param $answer_id
     * @return Boolean
     */
    public function getCorrectAnswer($question_id,$answer_id){

		DB::beginTransaction();

        try{

            $result = QuestionAnswer::questionId($question_id)->isCorrectAnswer()->find($answer_id);
            $response = is_null($result) ? false:true;

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
    }

	/**
	 * Get Question correct answer.
	 * @param $id
	 * @return mixed
	 */
	public function getQuestionCorrectAnswer($id){

		DB::beginTransaction();

		try {

			$return = QuestionAnswer::whereId($id)->pluck('correct_answer');

			$this->infoLog('ELOQUENT_RESPONSE: getQuestionCorrectAnswer -- ' . $return);

			$response = $return;

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @return bool
	 */
	public function getQuestionPointEquivalent($id){

		DB::beginTransaction();

		try {

			$response = QuestionAnswer::whereId($id)->pluck('point_equivalent');

			$this->infoLog('ELOQUENT_RESPONSE: getQuestionPointEquivalent -- ' . $response);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}