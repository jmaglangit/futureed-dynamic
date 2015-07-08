<?php

namespace FutureEd\Models\Repository\QuestionAnswer;

interface QuestionAnswerRepositoryInterface {

	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addQuestionAnswer($data);

}