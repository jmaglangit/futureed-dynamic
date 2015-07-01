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

}