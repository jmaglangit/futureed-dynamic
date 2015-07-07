<?php

namespace FutureEd\Models\Repository\Question;

use FutureEd\Models\Core\Question;
use League\Flysystem\Exception;


class QuestionRepository implements QuestionRepositoryInterface{

	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addQuestion($data){

		try {

			$question = Question::create($data);

		} catch(Exception $e) {

			return $e->getMessage();

		}

		return $question;

	}


	/**
	 * Gets list of Questions.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getQuestions($criteria = array(), $limit = 0, $offset = 0){

		$question = new Question();

		$count = 0;

		if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

			$count = $question->count();

		} else {


			if (count($criteria) > 0) {

				//check scope questions_text
				if(isset($criteria['questions_text'])){

					$question = $question->questionText($criteria['questions_text']);
				}

				//check scope to question_type
				if(isset($criteria['question_type'])){

					$question = $question->questionType($criteria['question_type']);
				}

			}

			$count = $question->count();

			if ($limit > 0 && $offset >= 0) {
				$question = $question->offset($offset)->limit($limit);
			}

		}

		return ['total' => $count, 'records' => $question->get()->toArray()];

	}
}