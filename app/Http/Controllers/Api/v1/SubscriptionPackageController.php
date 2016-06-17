<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\SubscriptionPackageRequest;
use FutureEd\Models\Repository\SubscriptionPackage\SubscriptionPackageRepositoryInterface;
use Illuminate\Support\Facades\Input;

class SubscriptionPackageController extends ApiController {

	protected $subscription_package;

	public function __construct(
		SubscriptionPackageRepositoryInterface $subscriptionPackageRepositoryInterface
	){
		$this->subscription_package = $subscriptionPackageRepositoryInterface;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0;
		$offset = 0;

		if(Input::get('subject_id')){
			$criteria['subject_id'] = Input::get('subject_id');
		}

		if(Input::get('days_id')){
			$criteria['days_id'] = Input::get('days_id');
		}

		if(Input::get('subscription_id')){
			$criteria['subscription_id'] = Input::get('subscription_id');
		}

		if(Input::get('country_id')){
			$criteria['country_id'] = Input::get('country_id');
		}

		if(Input::get('status')){
			$criteria['status'] = Input::get('status');
		}

		if(Input::get('limit')){
			$limit = Input::get('limit');
		}

		if(Input::get('offset')){
			$offset = Input::get('offset');
		}

		return $this->respondWithData($this->subscription_package->getSubscriptionPackages($criteria,$limit,$offset));
	}

	/**
	 * Get subscription package.
	 * @param $id
	 */
	public function show($id){

		return $this->respondWithData($this->subscription_package->getSubscriptionPackage($id));
	}

	/**
	 * store a new subscription package
	 * @param SubscriptionPackageRequest $request
	 * @return mixed
	 */
	public function store(SubscriptionPackageRequest $request){

		$data = $request->all();

		return $this->respondWithData($this->subscription_package->addSubscriptionPackage($data));
	}

	/**
	 * update a subscription package
	 * @param $id
	 * @param SubscriptionPackageRequest $request
	 * @return mixed
	 */
	public function update($id, SubscriptionPackageRequest $request){

		$data = $request->all();

		return $this->respondWithData($this->subscription_package->updateSubscriptionPackage($id,$data));
	}

	/**
	 * delete a subscription package
	 * @param $id
	 * @return mixed
	 */
	public function destroy($id){

		return $this->respondWithData($this->subscription_package->deleteSubscriptionPackage($id));
	}

}
