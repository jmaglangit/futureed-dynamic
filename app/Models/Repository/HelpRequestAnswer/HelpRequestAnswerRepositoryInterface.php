<?php namespace FutureEd\Models\Repository\HelpRequestAnswer;


interface HelpRequestAnswerRepositoryInterface {

	public function getHelpRequestAnswers($criteria,$limit,$offset);

	public function getHelpRequestAnswer($id);
}