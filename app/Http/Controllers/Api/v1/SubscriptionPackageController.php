<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\SubscriptionPackage\SubscriptionPackageRepositoryInterface;
use Illuminate\Http\Request;
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

		//TODO get inputs -->
		// subject_id
		//days_id
		//subscription_id
		//country_id
		//price
		//status

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

		return $this->respondWithData($this->subscription_package->getSubscriptionPackage($criteria,$limit,$offset));
	}

}
