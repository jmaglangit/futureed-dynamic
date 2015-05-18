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
        return Subscription::select('id','name','price','description','status')->where('id',$id)->first();
    }
    
     /**
	 * Update specific subscription.
	 *
	 * @param  array	$subscription
	 *
	 * @return object
	 */
	 
    public function updateSubscription($subscription){
    
        try{
            $result = Subscription::where('id','=',$subscription["id"])
                     ->update(['name'           =>$subscription['name'],
                               'price'          =>$subscription['price'],
                               'description'    =>$subscription['description'],
                               'status'         =>$subscription['status']]);
        }catch(Exception $e){
            return $e->getMessage();
        }
        return $result;
    }
    
    public function addSubscription($subscription){
    
        try{
            $result = Subscription::create($subscription);
        }catch(Exception $e){
            return $e->getMessage();        
        }   
        return $result;
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
            $result = Subscription::where('id',$id)->delete();
        }catch(Exception $e){
            return $e->getMessage();
        }
        return $result;
    }
}