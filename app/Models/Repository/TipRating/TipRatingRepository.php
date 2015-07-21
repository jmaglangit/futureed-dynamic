<?php namespace FutureEd\Models\Repository\TipRating;

use FutureEd\Models\Core\TipRating;
use League\Flysystem\Exception;


class TipRatingRepository implements TipRatingRepositoryInterface{

	public function addTipRating($data){

		try {

			$tip_rating = TipRating::create($data);

		} catch(Exception $e) {

			return $e->getMessage();

		}

		return $tip_rating;

	}

	/**
	 *
	 * @return average of rating field of a specific tip
	 */

	public function getAverageRating($tip_id){

		$tip_rating = new TipRating();

		$average = $tip_rating->tipId($tip_id)->avg(config('futureed.tip_rating'));

		$average = round($average);

		return $average;

	}

}