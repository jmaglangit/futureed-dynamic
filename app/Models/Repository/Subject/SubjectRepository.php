<?php
namespace FutureEd\Models\Repository\Subject;

use FutureEd\Models\Core\Subject;

class SubjectRepository implements SubjectRepositoryInterface {

	/**
	 * Display a listing of subjects.
	 *
	 * @param	array	$criteria
	 * @param	int		$limit
	 * @param	int		$offset
	 *
	 * @return array
	 */
    public function getSubjects($criteria = array(), $limit = 0, $offset = 0) {
		
		$subjects = new Subject();
		
		$count = 0;
		
		if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {
			
			$count = $subjects->count();
		
		} else {
			
			if(count($criteria) > 0) {
				if(isset($criteria['name'])) {
					$subjects = $subjects->name($criteria['name']);
				}				
			}
		
			$count = $subjects->count();
		
			if($limit > 0 && $offset >= 0) {
				$subjects = $subjects->offset($offset)->limit($limit);;
			}
														
		}
		
		$subjects = $subjects->orderBy('name', 'asc');
		
		return ['total' => $count, 'records' => $subjects->get()->toArray()];	
	}

        
 

}