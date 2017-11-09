<?php namespace FutureEd\Models\Repository\HelpRequestAnswer;


interface HelpRequestAnswerRepositoryInterface {

	public function getHelpRequestAnswers($criteria,$limit,$offset);

	public function getHelpRequestAnswer($id);

	public function updateHelpRequestAnswer($id,$data);

	public function deleteHelpRequestAnswer($id);

	public function updateRequestAnswerStatus($id,$status);

    public function addHelpRequestAnswer($data);

    public function checkStudentHelpRequestAnswer($student_id,$help_request_answer_id);
}