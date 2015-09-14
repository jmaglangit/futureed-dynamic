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
					$subjects = $subjects->with('areas')->name($criteria['name']);
				}


				if(isset($criteria['status'])) {
					$subjects = $subjects->with('areas')->status($criteria['status']);
				}
			}
		
			$count = $subjects->count();
		
			if($limit > 0 && $offset >= 0) {
				$subjects = $subjects->with('areas')->offset($offset)->limit($limit);;
			}
														
		}
		
		$subjects = $subjects->with('areas')->orderBy('name', 'asc');
		
		return ['total' => $count, 'records' => $subjects->get()->toArray()];	
	}

	/**
	 * Add subject.
	 *
	 * @param	array	$subject
	 *
	 * @return boolean
	 */
	public function addSubject($subject) {
		
		try {
		
			$subject = Subject::create($subject);
			
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
		
		return $subject;
		
	}
	
	/**
	 * Get subject.
	 *
	 * @param	int	$id
	 *
	 * @return Resource
	 */
	public function getSubject($id) {
				
		return Subject::with('areas')->find($id);
		
	}
	
	/**
	 * Update subject.
	 *
	 * @param	int	$id
	 * @param	array	$subject
	 *
	 * @return boolean
	 */
	public function updateSubject($id, $data) {
		
		try {
		
			$subject = Subject::with('areas')->find($id);

			unset($data['code']);

            //update related areas status.
			if($subject->areas->count() > 0 ){

				foreach($subject->areas as $areas => $area){

					$area->status = $data['status'];
				}
			}

			$subject->update($data);

            //update related table.
            $subject->push();


			
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
		
		return $subject;
		
	}
	
	/**
	 * Delete subject.
	 *
	 * @param	int	$id
	 * @param	array	$subject
	 *
	 * @return boolean
	 */
	public function deleteSubject($id) {
		
		try {
		
			$subject = Subject::find($id);
						
			return !is_null($subject) ? $subject->delete() : false;
			
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
				
	}

}