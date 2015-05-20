<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use FutureEd\Models\Repository\Subscription\SubscriptionRepositoryInterface as Subscription;

use FutureEd\Http\Requests\Api\SubscriptionRequest;
use FutureEd\Http\Requests\Api\StatusRequest;

class SubscriptionController extends ApiController {

	//holds the subscription repository
	protected $subscription;

	/**
	 * Subscription Controller constructor
	 *
	 * @return void
	 */
	public function __construct(Subscription $subscription) 
	{
		$this->subscription = $subscription;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = array();
		$limit = 0;
		$offset = 0;
			
		if(Input::get('name')) {
			$criteria['name'] = Input::get('name');
		}
				
		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}
		
		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}
			
		$subscription = $this->subscription->getSubscriptions($criteria, $limit, $offset);

		return $this->respondWithData($subscription);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SubscriptionRequest $request)
	{
		$data = $request->all();
	
		$subscription = $this->subscription->addSubscription($data);
		
		return $this->respondWithData(['id' => $subscription["id"]]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if(!is_null($id)){
    		return $this->respondWithData($this->subscription->getSubscription($id));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,SubscriptionRequest $request)
	{
	    if(!is_null($id)){
	    
    	    $data = $request->all();
            return $this->respondWithData($this->subscription->updateSubscription($id,$data));
	    }		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(!is_null($id)){
    		return $this->respondWithData($this->subscription->deleteSubscription($id));
		}
	}
    
    public function updateStatus($id,StatusRequest $request){
        $data = $request->all();
        return $this->respondWithData($this->subscription->updateSubscription($id,$data));
    }
}
