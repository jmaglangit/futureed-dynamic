<?php namespace FutureEd\Models\Repository\AnswerExplanation;

use FutureEd\Models\Core\AnswerExplanation;

class AnswerExplanationRepository implements  AnswerExplanationRepositoryInterface{

	/**
	 * Get specefic answer explanation.
	 * @param $module_id
	 * @param $question_id
	 * @param $seq_no
	 * @return mixed
	 */
	public function getAnswerExplanation($module_id, $question_id,$seq_no){

		return AnswerExplanation::moduleId($module_id)
			->questionId($question_id)
			->seqNo($seq_no)
			->first();
	}

}