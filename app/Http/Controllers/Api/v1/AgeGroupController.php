<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Core\AgeGroup;
use FutureEd\Models\Repository\AgeGroup\AgeGroupRepositoryInterface;
use Illuminate\Http\Request;

class AgeGroupController extends ApiController {

	protected $age_group;

	public function __construct(
		AgeGroupRepositoryInterface $ageGroupRepositoryInterface
	){
		$this->age_group = $ageGroupRepositoryInterface;
	}

	/**
	 * Display list of Age Group.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->respondWithData(
			$this->age_group->getAges()
		);

	}

}
