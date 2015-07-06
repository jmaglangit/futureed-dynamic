<?php namespace FutureEd\Models\Repository\HelpRequestAnswerRating;

interface HelpRequestAnswerRatingRepositoryInterface {
    public function checkStudentRating($student_id,$help_request_answer_id);
    public function addRating($data);
    public function getRatingsByAnswerId($help_request_answer_id);
}