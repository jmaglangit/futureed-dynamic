<?php
namespace FutureEd\Models\Repository\Subscription;

use FutureEd\Models\Core\Subscription;

class SubscriptionRepository implements SubscriptionRepositoryInterface {

	/**
	 * Display a listing of subscriptions.
	 *
	 * @param	array	$criteria
	 * @param	int		$limit
	 * @param	int		$offset
	 *
	 * @return array
	 */
    public function getSubscriptions($criteria = array(), $limit = 0, $offset = 0) {
		
		$subscriptions = new Subscription();
		
		$count = 0;
		
		if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {
			
			$count = $subscriptions->count();
		
		} else {
			
			if(count($criteria) > 0) {
				if(isset($criteria['name'])) {
					$subscriptions = $subscriptions->name($criteria['name']);
				}				
			}
		
			$count = $subscriptions->count();
		
			if($limit > 0 && $offset >= 0) {
				$subscriptions = $subscriptions->offset($offset)->limit($limit);
			}
														
		}
		
		$subscriptions = $subscriptions->orderBy('name', 'asc');
		
		return ['total' => $count, 'records' => $subscriptions->get()->toArray()];	
	}

    /**
	 * Display specific subscription by id.
	 *
	 * @param	int	$id
	 *
	 * @return object
	 */
    public function getSubscription($id){
        return Subscription::find($id);
    }
    
     /**
	 * Update specific subscription.
	 *
	 * @param  array	$subscription
	 *
	 * @return object
	 */
	 
    public function updateSubscription($id,$subscription){
    
        try{
            $result = Subscription::find($id);
            return !is_null($result) ? $result->update($subscription) : false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    public function addSubscription($subscription){
    
        try{
            return Subscription::create($subscription)->toArray();
        }catch(Exception $e){
            return $e->getMessage();        
        }
    }
     /**
	 * Delete specific subscription.
	 *
	 * @param  id	$subscription
	 *
	 * @return boolean
	 */
    public function deleteSubscription($id){
        
        try{
            $result = Subscription::find($id);
            return !is_null($result) ? $result->delete() : false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}