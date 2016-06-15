<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\SubscriptionDayRequest;
use FutureEd\Models\Repository\SubscriptionDay\SubscriptionDayRepositoryInterface;
use Illuminate\Support\Facades\Input;

class SubscriptionDayController extends ApiController {

	protected $subscription_day;

	public function __construct(
		SubscriptionDayRepositoryInterface $subscriptionDayRepositoryInterface
	){
		$this->subscription_day = $subscriptionDayRepositoryInterface;
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

		if(Input::get('days')){
			$criteria['days'] = Input::get('days');
		}

		if(Input::get('status')){
			$criteria['status'] = Input::get('status');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		$subscription_days = $this->subscription_day->getSubscriptionDays($criteria,$limit,$offset);

		return $this->respondWithData($subscription_days);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param SubscriptionDayRequest $request
	 * @return Response
	 */
	public function store(SubscriptionDayRequest $request){

		$data = $request->all();

		$subscription_day = $this->subscription_day->addSubscriptionDay($data);

		return $this->respondWithData([
			'id' => $subscription_day['id']
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->subscription_day->getSubscriptionDay($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param SubscriptionDayRequest $request
	 * @return Response
	 */
	public function update($id, SubscriptionDayRequest $request){

		$data = $request->all();

		return $this->respondWithData($this->subscription_day->updateSubscriptionDay($id,$data));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return $this->respondWithData($this->subscription_day->deleteSubscriptionDay($id));
	}
}
