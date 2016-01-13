<?php  namespace FutureEd\Models\Repository\PointLevel;


interface PointLevelRepositoryInterface {

	public function findPointsLevel($points_required);
	public function getPointsLevel($points_required);
}
