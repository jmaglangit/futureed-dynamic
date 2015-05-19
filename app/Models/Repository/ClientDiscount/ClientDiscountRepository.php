<?php
namespace FutureEd\Models\Repository\ClientDiscount;

use FutureEd\Models\Core\ClientDiscount;

class ClientDiscountRepository implements ClientDiscountRepositoryInterface {

	/**
	 * Display a listing of client discounts.
	 *
	 * @param	array	$criteria
	 * @param	int		$limit
	 * @param	int		$offset
	 *
	 * @return array
	 */
    public function getClientDiscounts($criteria = array(), $limit = 0, $offset = 0) {
		
		$clientDiscounts = new ClientDiscount();
		
		$count = 0;
		
		$clientDiscounts = $clientDiscounts->with('client');
		
		if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {
			
			$count = $clientDiscounts->count();
		
		} else {
			
			if(count($criteria) > 0) {
				if(isset($criteria['name'])) {
					$clientDiscounts = $clientDiscounts->name($criteria['name']);
				}
				if(isset($criteria['client_role'])) {
					$clientDiscounts = $clientDiscounts->role($criteria['client_role']);
				}				
			}
		
			$count = $clientDiscounts->count();
		
			if($limit > 0 && $offset >= 0) {
				$clientDiscounts = $clientDiscounts->offset($offset)->limit($limit);
			}
														
		}
		
		return ['total' => $count, 'records' => $clientDiscounts->get()->toArray()];	
	}

    /**
	 * Display specific subscription by id.
	 *
	 * @param	int	$id
	 *
	 * @return object
	 */
    public function getClientDiscount($id){
        return ClientDiscount::find($id);
    }
    
     /**
	 * Update specific subscription.
	 *
	 * @param  array	$subscription
	 *
	 * @return object
	 */
	 
    public function updateClientDiscount($clientDiscount){
    
        try{
            $result = ClientDiscount::find($clientDiscount["id"]);
            return !is_null($result) ? $result->update($clientDiscount) : false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
     /**
	 * Add specific subscription.
	 *
	 * @param  array	$subscription
	 *
	 * @return object
	 */
	 
    public function addClientDiscount($clientDiscount){
    
        try{
            return ClientDiscount::create($clientDiscount)->toArray();
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
    public function deleteClientDiscount($id){
        
        try{
            $result = ClientDiscount::find($id);
            return !is_null($result) ? $result->delete() : false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}