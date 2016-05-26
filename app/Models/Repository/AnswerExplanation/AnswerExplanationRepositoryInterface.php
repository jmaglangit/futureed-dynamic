<?php namespace FutureEd\Models\Repository\AnswerExplanation;


interface AnswerExplanationRepositoryInterface {

	public function getAnswerExplanation($module_id, $question_id,$seq_no);

}