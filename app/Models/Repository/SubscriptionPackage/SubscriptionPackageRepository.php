<?php namespace FutureEd\Models\Repository\SubscriptionPackage;

use FutureEd\Models\Core\SubscriptionPackages;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class SubscriptionPackageRepository implements SubscriptionPackageRepositoryInterface {

	use LoggerTrait;

	/**
	 * Get subscription packages
	 * @param array $criteria
	 * @param $limit
	 * @param $offset
	 * @return array|bool
	 */
	public function getSubscriptionPackages($criteria = [], $limit, $offset){

		DB::beginTransaction();

		try{

			$subscription_package = new SubscriptionPackages();

			if(isset($criteria['subject_id'])){

				$subscription_package = $subscription_package->subjectId($criteria['subject_id']);
			}

			if(isset($criteria['days_id'])){
				$subscription_package = $subscription_package->dayId($criteria['days_id']);
			}

			if(isset($criteria['subscription_id'])){
				$subscription_package = $subscription_package->subscriptionId($criteria['subscription_id']);
			}
			if(isset($criteria['country_id'])){
				$subscription_package = $subscription_package->countryId($criteria['country_id']);
			}

			if(isset($criteria['status'])){
				$subscription_package = $subscription_package->status($criteria['status']);
			}

			if(isset($criteria['trial']) && $criteria['trial'] == 1){
				$subscription_package = $subscription_package->statusTrial();
			}

			$subscription_package = $subscription_package->with('subject','subscription_day','country','subscription');

			$count = $subscription_package->count();

			if ($offset >= 0 && $limit > 0) {
				$subscription_package = $subscription_package->skip($offset)->take($limit);
			}

			$response = [
				'total' => $count,
				'records' => $subscription_package->get()
			];

		}catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get a package record.
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getSubscriptionPackage($id){

		return SubscriptionPackages::find($id);
	}

	/**
	 * Get country list.
	 * @return mixed
	 */
	public function getSubscriptionCountries(){

		$subscription_package = new SubscriptionPackages();

		return $subscription_package->with('country')->groupBy('country_id')->get();
	}

	/**
	 * Add a subscription package
	 * @param $data
	 * @return array|bool
	 */
	public function addSubscriptionPackage($data){

		DB::beginTransaction();

		try{

			$response = SubscriptionPackages::create($data)->toArray();

		}catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * update a subscription package
	 * @param $id
	 * @param $data
	 * @return bool|int
	 */
	public function updateSubscriptionPackage($id, $data){

		DB::beginTransaction();

		try{

			$package = SubscriptionPackages::find($id);

			$response = !is_null($package) ? $package->update($data) : false;

		}catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * Delete a subscription package
	 * @param $id
	 * @return bool|null
	 */
	public function deleteSubscriptionPackage($id){

		DB::beginTransaction();

		try{

			$package = SubscriptionPackages::find($id);

			$response = $package->delete();

		}catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

}