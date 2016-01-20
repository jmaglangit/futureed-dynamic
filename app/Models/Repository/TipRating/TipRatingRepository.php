<?php namespace FutureEd\Models\Repository\TipRating;

use FutureEd\Models\Core\TipRating;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;


class TipRatingRepository implements TipRatingRepositoryInterface{

	use LoggerTrait;

	/**
	 * @param $data
	 * @return bool|static
	 */
	public function addTipRating($data){

		DB::beginTransaction();

		try {

			$response = TipRating::create($data);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Average of rating field of a specific tip
	 * @param $tip_id
	 * @return bool|float
	 */
	public function getAverageRating($tip_id){

		DB::beginTransaction();

		try {

			$tip_rating = new TipRating();

			$average = $tip_rating->tipId($tip_id)->avg(config('futureed.tip_rating'));

			$response = round($average);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

}