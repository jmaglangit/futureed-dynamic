<?php

namespace FutureEd\Models\Repository\QuestionAnswer;

interface QuestionAnswerRepositoryInterface {

	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addQuestionAnswer($data);

	/**
	 * Gets list of QuestionAnswers.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getQuestionAnswers($criteria = array(), $limit = 0, $offset = 0);

	/**
	 * Get a record on QuestionAnswer.
	 * @param $id
	 * @return mixed
	 */
	public function viewQuestionAnswer($id);

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */

	public function updateQuestionAnswer($id,$data);

	/**
	 * Delete a record.
	 * @param $id
	 * @return bool|null|string
	 * @throws \Exception
	 */
	public function deleteQuestionAnswer($id);

    /**
     * Get correct answer from question.
     * @param $question_id
     * @param $answer_id
     * @return object
     */
    public function getCorrectAnswer($question_id,$answer_id);
}