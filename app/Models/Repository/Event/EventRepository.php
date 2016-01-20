<?php namespace FutureEd\Models\Repository\Event;


use FutureEd\Models\Core\Event;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class EventRepository implements EventRepositoryInterface{
	use LoggerTrait;

	/**
	 * Gets list of Events.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getEvents($criteria = array(), $limit = 0, $offset = 0){
		DB::beginTransaction();

		try{
			$event = new Event();

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $event->count();

			} else {

				if (count($criteria) > 0) {

					//check scope name
					if(isset($criteria['name'])){

						$event = $event->name($criteria['name']);
					}


				}

				$count = $event->count();

				if ($limit > 0 && $offset >= 0) {
					$event = $event->offset($offset)->limit($limit);
				}
			}

			$response = ['total' => $count, 'records' => $event->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}