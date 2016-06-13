<?php namespace FutureEd\Models\Repository\SubscriptionDay;

use FutureEd\Models\Core\SubscriptionDay;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class SubscriptionDayRepository implements SubscriptionDayRepositoryInterface{

	use LoggerTrait;

	/**
	 * Get list of subscription days.
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array|bool
	 */
	public function getSubscriptionDays($criteria = [], $limit = 0, $offset = 0) {

		DB::beginTransaction();

		try {

			$subscription_day = new SubscriptionDay();

			$count = 0;

			if (isset($criteria['days'])) {
				$subscription_day = $subscription_day->days($criteria['days']);
			}

			if (isset($criteria['status'])) {
				$subscription_day = $subscription_day->status($criteria['status']);
			}

			$count = $subscription_day->count();

			if ($offset >= 0 && $limit > 0) {
				$subscription_day = $subscription_day->skip($offset)->take($limit);
			}

			$response = [
				'total' => $count,
				'records' => $subscription_day->get()
			];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get a subscription record.
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getSubscriptionDay($id){
		return SubscriptionDay::find($id);
	}

	/**
	 * Add new subscription day
	 * @param $data
	 * @return array|bool
	 */
	public function addSubscriptionDay($data){

		DB::beginTransaction();

		try{

			$response = SubscriptionDay::create($data)->toArray();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update a subscription day
	 * @param $id
	 * @param $data
	 * @return bool|int
	 */
	public function updateSubscriptionDay($id, $data){

		DB::beginTransaction();

		try{

			$subscription_day = SubscriptionDay::find($id);

			$response = !is_null($subscription_day) ? $subscription_day->update($data) : false;

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * Delete a subscription
	 * @param $id
	 * @return bool|null
	 */
	public function deleteSubscriptionDay($id){

		DB::beginTransaction();

		try{

			$subscription_day = SubscriptionDay::find($id);

			$response = $subscription_day->delete();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}