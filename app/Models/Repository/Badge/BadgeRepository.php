<?php namespace FutureEd\Models\Repository\Badge;


use FutureEd\Models\Core\Badge;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

class BadgeRepository implements BadgeRepositoryInterface{

	/**
	 * Gets list of Badges.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getBadges($criteria = array(), $limit = 0, $offset = 0){

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

		return ['total' => $count, 'records' => $badge->get()->toArray()];

	}
}
