<?php namespace FutureEd\Models\Repository\HelpRequestAnswerRating;


use FutureEd\Models\Core\HelpRequestAnswerRating;

class HelpRequestAnswerRatingRepository implements HelpRequestAnswerRatingRepositoryInterface{

    /**
     * Check student rating if exists.
     * @param $student_id
     * @param $help_request_answer_id
     * @return null|string
     *
     */
    public function checkStudentRating($student_id,$help_request_answer_id){
        try{
            $result = HelpRequestAnswerRating::StudentId($student_id)->HelpRequestAnswerId($help_request_answer_id)->first();
            return is_null($result) ? null : $result->toArray();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Add Help Request Answer Rating.
     * @param $data
     * @return string|static
     */
    public function addRating($data){
        try{
            return HelpRequestAnswerRating::create($data);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Get ratings by answer id
     * @param $help_request_answer_id
     * @return string
     */
    public function getRatingsByAnswerId($help_request_answer_id){
        try{
            return HelpRequestAnswerRating::HelpRequestAnswerId($help_request_answer_id)->get();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}