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

	/**
	 * Get a record on Question.
	 * @param $id
	 * @return mixed
	 */
	public function viewQuestion($id);

	/**
	 * Delete a record.
	 * @param $id
	 * @return bool|null|string
	 * @throws \Exception
	 */
	public function deleteQuestion($id);

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */

	public function updateQuestion($id,$data);

	/**
	 * Get number of row.
	 * @param $module_id
	 * @param $data
	 * @return int
	 */
	public function getQuestionCount($module_id);


	public function getQuestionSequenceNos($module_id,$difficulty);

	public function getQuestionSequenceNo($id);

	public function getLastSequence($module_id,$difficulty);

	public function updateSequence($sequence);




}