<?php namespace FutureEd\Models\Repository\Badge;


use FutureEd\Models\Core\Badge;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

class BadgeRepository implements BadgeRepositoryInterface{

	use LoggerTrait;

	/**
	 * Gets list of Badges.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getBadges($criteria = array(), $limit = 0, $offset = 0){

		DB::beginTransaction();

		try{
			$badge = new Badge();

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $badge->count();

			} else {


				if (count($criteria) > 0) {

					//check scope name
					if(isset($criteria['name'])){

						$badge = $badge->name($criteria['name']);
					}

				}

				$count = $badge->count();

				if ($limit > 0 && $offset >= 0) {
					$badge = $badge->offset($offset)->limit($limit);
				}

			}

			$response = ['total' => $count, 'records' => $badge->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


	/**
	 * Gets  Completed Badge details.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getCompletedBadges($criteria = array()){

		DB::beginTransaction();

		try{
			$badge = new Badge();

			$badge = $badge->ageGroupId($criteria['age_group_id']);
			$badge = $badge->subjectId($criteria['subject_id']);
			$badge = $badge->gender($criteria['gender']);

			$response = $badge->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}
}