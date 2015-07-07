<?php

namespace FutureEd\Models\Repository\Question;

interface QuestionRepositoryInterface {

	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addQuestion($data);

	/**
	 * Gets list of Questions.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getQuestions($criteria = array(), $limit = 0, $offset = 0);

}