<?php
namespace FutureEd\Models\Repository\SubjectArea;

use FutureEd\Models\Core\SubjectArea;

class SubjectAreaRepository implements SubjectAreaRepositoryInterface {
	
	/**
	 * Get a listing of subject areas by subject id.
	 *
	 * @param	int		$subject_id
	 *
	 * @return array
	 */	
	public function getAreasBySubjectId($subject_id) {
		
		$subject_areas = SubjectArea::subjectId($subject_id)->get();
		
		return $subject_areas;
		
	}
	
	/**
	 * Display a listing of subject areas.
	 *
	 * @param	array	$criteria
	 * @param	int		$limit
	 * @param	int		$offset
	 *
	 * @return array
	 */
    public function getSubjectAreas($criteria = array(), $limit = 0, $offset = 0) {
		
		$subject_areas = new SubjectArea();
		
		$count = 0;
		
		if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {
			
			$count = $subject_areas->count();
		
		} else {
			
			if(count($criteria) > 0) {
				if(isset($criteria['name'])) {
					$subject_areas = $subject_areas->name($criteria['name']);
				}

                if(isset($criteria['subject_id'])) {
                    $subject_areas = $subject_areas->subjectid($criteria['subject_id']);
                }


            }
		
			$count = $subject_areas->count();
		
			if($limit > 0 && $offset >= 0) {
				$subject_areas = $subject_areas->offset($offset)->limit($limit);;
			}
														
		}
		
		$subject_areas = $subject_areas->orderBy('name', 'asc');
		
		return ['total' => $count, 'records' => $subject_areas->get()->toArray()];	
	}

	/**
	 * Add subject area.
	 *
	 * @param	array	$subject_area
	 *
	 * @return boolean
	 */
	public function addSubjectArea($subject_area) {
		
		try {
		
			$subject_area = SubjectArea::create($subject_area);
			
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
		
		return $subject_area;
		
	}

	/**
	 * Get subject area.
	 *
	 * @param	int	$id
	 *
	 * @return Resource
	 */
	public function getSubjectArea($id) {
				
		return SubjectArea::find($id);
		
	}

	/**
	 * Update subject area.
	 *
	 * @param	int	$id
	 * @param	array	$data
	 *
	 * @return boolean
	 */
	public function updateSubjectArea($id, $data) {
		
		try {
		
			$subject_area = SubjectArea::find($id);
			
			unset($data['code']);
			
			$subject_area->update($data);
			
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
		
		return $subject_area;
		
	}
	
	/**
	 * Delete subject area.
	 *
	 * @param	int	$id
	 * @param	array	$subject
	 *
	 * @return boolean
	 */
	public function deleteSubjectArea($id) {
		
		try {
		
			$subject_area = SubjectArea::find($id);
						
			return !is_null($subject_area) ? $subject_area->delete() : false;
			
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
				
	}

}