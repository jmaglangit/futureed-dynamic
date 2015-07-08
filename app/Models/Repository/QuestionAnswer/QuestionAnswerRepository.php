<?php

namespace FutureEd\Models\Repository\QuestionAnswer;

use FutureEd\Models\Core\QuestionAnswer;
use League\Flysystem\Exception;


class QuestionAnswerRepository implements QuestionAnswerRepositoryInterface{

	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addQuestionAnswer($data){

		try {

			$question_answer = QuestionAnswer::create($data);

		} catch(Exception $e) {

			return $e->getMessage();

		}

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

		$question_answer = new QuestionAnswer();

		$count = 0;

		if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

			$count = $question_answer->count();

		} else {


			if (count($criteria) > 0) {

				//for question_id
				if(isset($criteria['question_id'])) {

					$question_answer = $question_answer->questionId($criteria['question_id']);

				}

			}

			$count = $question_answer->count();

			if ($limit > 0 && $offset >= 0) {
				$question_answer = $question_answer->offset($offset)->limit($limit);
			}

		}

		return ['total' => $count, 'records' => $question_answer->get()->toArray()];

	}

	/**
	 * Get a record on QuestionAnswer.
	 * @param $id
	 * @return mixed
	 */
	public function viewQuestionAnswer($id){

		$question_answer = new QuestionAnswer();

		$question_answer = $question_answer->find($id);
		return $question_answer;

	}


	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */

	public function updateQuestionAnswer($id,$data){

		try{

			return QuestionAnswer::find($id)
				->update($data);

		}catch (Exception $e){

			return $e->getMessage();
		}
	}
}