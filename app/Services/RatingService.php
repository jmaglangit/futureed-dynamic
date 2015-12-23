<?php namespace FutureEd\Services;

class RatingService {
    public function calculateHelpRequestAnswerRating($ratings = []){

        $calculated_rating = 0;
        if(count($ratings) > 0){
            $total_ratings =  count($ratings);
            $sum_of_ratings = 0;

            foreach($ratings as $rating){
                $sum_of_ratings += $rating['rating'];
            }

            $calculated_rating = floor( $sum_of_ratings / $total_ratings );
        }
        return $calculated_rating;
    }

    public function getPointsEquivalent($rating){
        switch ($rating) {
            case 1:
                return 4;
                break;

            case 2:
                return 8;
                break;

            case 3:
                return 12;
                break;

            case 4:
                return 16;
                break;

            case 5:
                return 20;
                break;

            default:
                return 0;
                break;
        }
    }
}