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

    /**
     * Returns points equivalent to provided rating.
     * @param $rating
     * @return int
     **/
    public function getPointsEquivalent($rating){
        switch ($rating) {
            case config('futureed.rating_1'):
                return config('futureed.rating_points_4');
                break;

            case config('futureed.rating_2'):
                return config('futureed.rating_points_8');
                break;

            case config('futureed.rating_3'):
                return config('futureed.rating_points_12');
                break;

            case config('futureed.rating_4'):
                return config('futureed.rating_points_16');
                break;

            case config('futureed.rating_5'):
                return config('futureed.rating_points_20');
                break;

            default:
                return config('futureed.rating_points_0');
                break;
        }
    }
}