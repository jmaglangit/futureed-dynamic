<?php namespace FutureEd\Models\Repository\PointLevel;

use FutureEd\Models\Core\PointLevel;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class PointLevelRepository implements PointLevelRepositoryInterface{

	use LoggerTrait;

	/**
	 * find the data where points_required belong to
	 * @param $points_required;
	 * @return object
	 */
	public function findPointsLevel($points_required){

		DB::beginTransaction();

		try {
			$point_level = new PointLevel();

			$point_level = $point_level->pointRequired($points_required);
			$point_level = $point_level->orderByPointRequiredDesc();

			$response = $point_level->first();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Retruns an array of points_level for the student
	 * @param $points_required;
	 * @return object
	 */
	public function getPointsLevel($points_required){

		DB::beginTransaction();

		try {
			$point_level['records'] = PointLevel::pointRequired($points_required)->get();
		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $point_level;
	}
}