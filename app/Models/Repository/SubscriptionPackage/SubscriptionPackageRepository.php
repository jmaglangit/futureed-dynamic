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
	public function getSubscriptionPackage($criteria = [], $limit, $offset){

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

			$subscription_package = $subscription_package->with('subject','subscription_day','country','subscription');

			$count = $subscription_package->get()->count();

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
	 * Get country list.
	 * @return mixed
	 */
	public function getSubscriptionCountries(){

		$subscription_package = new SubscriptionPackages();

		return $subscription_package->with('country')->groupBy('country_id')->get();
	}

}