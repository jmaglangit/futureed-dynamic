<?php namespace FutureEd\Http\Controllers\Api\v1;

//use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\PointLevel\PointLevelRepositoryInterface;

class PointLevelController extends ApiController {
	protected $points_required;

	public function __construct(PointLevelRepositoryInterface $point_level) {
		$this->point_level = $point_level;
	}

	public function show($points_required){
		$point_level = $this->point_level->getPointsLevel($points_required);
		return $this->respondWithData($point_level);
	}
}