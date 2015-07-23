<?php namespace FutureEd\Models\Repository\StudentPoint;

use FutureEd\Models\Core\StudentPoint;

class StudentPointRepository implements StudentPointRepositoryInterface{


	/**
	 * Display a listing of subscriptions.
	 *
	 * @param	array	$criteria
	 * @param	int		$limit
	 * @param	int		$offset
	 *
	 * @return array
	 */
	public function getStudentPoints($criteria = array(), $limit = 0, $offset = 0) {

		$student_point = new StudentPoint();

		$count = 0;

		if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {

			$count = $student_point->count();

		} else {

			if(count($criteria) > 0) {
				if(isset($criteria['student_id'])) {
					$student_point = $student_point->studentId($criteria['student_id']);
				}
			}

			$count = $student_point->count();

			if($limit > 0 && $offset >= 0) {
				$student_point = $student_point->offset($offset)->limit($limit);
			}

		}

		return ['total' => $count, 'records' => $student_point->get()->toArray()];
	}

}


