<?php namespace FutureEd\Models\Repository\PointLevel;

use FutureEd\Models\Core\PointLevel;

class PointLevelRepository implements PointLevelRepositoryInterface{

	/**
	 * find the data where points_required belong to
	 * @param $points_required;
	 * @return object
	 */
	public function findPointsLevel($points_required){

		$point_level = new PointLevel();

		$point_level = $point_level->pointRequired($points_required);
		$point_level = $point_level->orderByPointRequiredDesc();

		return $point_level->first();
	}

	/**
	 * Retruns an array of points_level for the student
	 * @param $points_required;
	 * @return object
	 */
	public function getPointsLevel($points_required){

		try {
			$point_level['records'] = PointLevel::pointRequired($points_required)->get();
		} catch (Exception $e) {
			return $e->getMessage();
		}

		return $point_level;
	}
}