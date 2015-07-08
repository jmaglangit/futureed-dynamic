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

			$question = QuestionAnswer::create($data);

		} catch(Exception $e) {

			return $e->getMessage();

		}

		return $question;

	}
}