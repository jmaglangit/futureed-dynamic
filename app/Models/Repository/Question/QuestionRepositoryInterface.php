<?php

namespace FutureEd\Models\Repository\Question;

interface QuestionRepositoryInterface {

	/**
	 *add record to questions table
	 */
	public function addQuestion($data);

	public function getQuestions($criteria = array(), $limit = 0, $offset = 0);

}