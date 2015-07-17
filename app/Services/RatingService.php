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
}