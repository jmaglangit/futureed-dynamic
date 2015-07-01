<?php namespace FutureEd\Models\Repository\HelpRequestAnswer;


use FutureEd\Models\Core\HelpRequestAnswer;

class HelpRequestAnswerRepository implements HelpRequestAnswerRepositoryInterface{

	/**
	 * Gets list of Help Request Answers.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getHelpRequestAnswers($criteria,$limit,$offset){

		$help_request_answer = new HelpRequestAnswer();

		/*
		 * Filters:
		 * help_request
		 * module
		 * subject_area
		 * subject
		 * request_answer_status
		 *
		 */
		if(isset($criteria['help_request'])){

			$help_request_answer = $help_request_answer->RequestTitle($criteria['help_request']);
		}

		if(isset($criteria['module'])){

			$help_request_answer = $help_request_answer->ModuleName($criteria['module']);

		}

		if(isset($criteria['subject'])){

			$help_request_answer = $help_request_answer->SubjectName($criteria['subject']);
		}

		if(isset($criteria['subject_area'])){

			$help_request_answer = $help_request_answer->SubjectAreaName($criteria['subject_area']);
		}

		if(isset($criteria['request_answer_status'])){

			$help_request_answer = $help_request_answer->AnswerStatus($criteria['request_answer_status']);

		}

		$help_request_answer = $help_request_answer
			->with('helpRequest','module','subject','subjectArea')
			->StatusEnabled();

		$count = $help_request_answer->count();

		if($limit > 0 && $offset >= 0) {
			$help_request_answer = $help_request_answer->offset($offset)->limit($limit);
		}

		return [
			'total' => $count,
			'records' => $help_request_answer->get()
		];

	}

	/**
	 * Get a record on Help Request Answer.
	 * @param $id
	 * @return mixed
	 */
	public function getHelpRequestAnswer($id){

		return HelpRequestAnswer::with('helpRequest','module','subject','subjectArea')
			->StatusEnabled()->find($id);

	}

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */
	public function updateHelpRequestAnswer($id,$data){

		try {

			HelpRequestAnswer::find($id)
				->update($data);

			return $this->getHelpRequestAnswer($id);

		} catch(Exception $e){

			return $e->getMessage();
		}
	}

	/**
	 * Delete a record.
	 * @param $id
	 * @return bool|null|string
	 * @throws \Exception
	 */
	public function deleteHelpRequestAnswer($id){

		try{

			return HelpRequestAnswer::find($id)
				->delete();

		}catch (Exception $e){

			return $e->getMessage();
		}
	}



}