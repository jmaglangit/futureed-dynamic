<?php
namespace FutureEd\Models\Repository\VolumeDiscount;

use FutureEd\Models\Core\VolumeDiscount;

class VolumeDiscountRepository implements VolumeDiscountRepositoryInterface {

	/**
	 * Display a listing of VolumeDiscounts.
	 *
	 * @param	array	$criteria
	 * @param	int		$limit
	 * @param	int		$offset
	 *
	 * @return array
	 */
    public function getVolumeDiscounts($criteria = array(), $limit = 0, $offset = 0) {
		
		$volumeDiscounts = new VolumeDiscount();
		
		$count = 0;
		
		if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {
			
			$count = $volumeDiscounts->count();
		
		} else {
			
			if(count($criteria) > 0) {
				if(isset($criteria['min_seats'])) {
					$volumeDiscounts = $volumeDiscounts->minSeats($criteria['min_seats']);
				}				
			}
		
			$count = $volumeDiscounts->count();
		
			if($limit > 0 && $offset >= 0) {
				$volumeDiscounts = $volumeDiscounts->offset($offset)->limit($limit);
			}
														
		}
		
		$volumeDiscounts = $volumeDiscounts->orderBy('min_seats', 'asc');
		
		return ['total' => $count, 'records' => $volumeDiscounts->get()->toArray()];	
	}

    /**
	 * Display specific VolumeDiscount by id.
	 *
	 * @param	int	$id
	 *
	 * @return object
	 */
    public function getVolumeDiscount($id){
        return VolumeDiscount::find($id);
    }
    
     /**
	 * Update specific VolumeDiscount.
	 *
	 * @param  array	$volumeDiscount
	 *
	 * @return object
	 */
	 
    public function updateVolumeDiscount($id,$volumeDiscount){
    
        try{
            $result = VolumeDiscount::find($id);
            return !is_null($result) ? $result->update($volumeDiscount) : false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    
    public function addVolumeDiscount($volumeDiscount){
    
        try{
            return VolumeDiscount::create($volumeDiscount)->toArray();
        }catch(Exception $e){
            return $e->getMessage();        
        }
    }
     /**
	 * Delete specific VolumeDiscount.
	 *
	 * @param  id	$volumeDiscount
	 *
	 * @return boolean
	 */
    public function deleteVolumeDiscount($id){
        
        try{
            $result = VolumeDiscount::find($id);
            return !is_null($result) ? $result->delete() : false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     *  Get rounded off discount to be used in invoice discount.
     *  @param $min_seats int
     *  @return object
     */

    public function getRoundedOffDiscount($min_seats){
        return VolumeDiscount::floorMinSeats($min_seats)->orderBy('id', 'desc')->first();
    }
}