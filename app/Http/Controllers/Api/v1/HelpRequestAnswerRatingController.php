<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\HelpRequestAnswerRatingRequest;
use FutureEd\Models\Repository\HelpRequestAnswer\HelpRequestAnswerRepositoryInterface;
use FutureEd\Models\Repository\HelpRequestAnswerRating\HelpRequestAnswerRatingRepositoryInterface;
use FutureEd\Services\RatingService;

class HelpRequestAnswerRatingController extends ApiController{

    protected $help_request_answer;
    protected $help_request_answer_rating;
    protected $rating;

    public function __construct(HelpRequestAnswerRepositoryInterface $help_request_answer,
                                HelpRequestAnswerRatingRepositoryInterface $help_request_answer_rating,
                                RatingService $rating){
        $this->help_request_answer = $help_request_answer;
        $this->help_request_answer_rating = $help_request_answer_rating;
        $this->rating = $rating;
    }

    /**
     * Add ratings.
     * @param HelpRequestAnswerRatingRequest $request
     * @return mixed
     */
    public function store(HelpRequestAnswerRatingRequest $request){
        $data = $request->all();

        //check if the student has already rated the answer.
        $student_rating = $this->help_request_answer_rating->checkStudentRating($data['student_id'],$data['help_request_answer_id']);

        if(!is_null($student_rating)){
            return $this->respondErrorMessage(2042);
        }

        //check the owner of the answer. student cannot rate his/her own answer.
        $student_answer = $this->help_request_answer->checkStudentHelpRequestAnswer($data['student_id'],$data['help_request_answer_id']);

        if(!is_null($student_answer)){
            return $this->respondErrorMessage(2043);
        }

        //Add the rating.
        $rating = $this->help_request_answer_rating->addRating($data);

        //Update the rating of the answer.
        $ratings = $this->help_request_answer_rating->getRatingsByAnswerId($rating['help_request_answer_id']);

        if(count($ratings) > 0 ){
            $ratings = $ratings->toArray();

            $calculated_rating = $this->rating->calculateHelpRequestAnswerRating($ratings);
            $help_request_answer_data['rating'] = $calculated_rating;
            $this->help_request_answer->updateHelpRequestAnswer($rating['help_request_answer_id'],$help_request_answer_data);
        }

        return $this->respondWithData($rating);

    }
}