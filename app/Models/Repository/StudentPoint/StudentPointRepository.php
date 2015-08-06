<?php namespace FutureEd\Models\Repository\StudentPoint;

use FutureEd\Models\Core\StudentPoint;

class StudentPointRepository implements StudentPointRepositoryInterface{


	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addStudentPoint($data){

		try {

			$student_point = StudentPoint::create($data);

		} catch(Exception $e) {

			return $e->getMessage();

		}

		return $student_point;

	}


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
		$student_point = $student_point->with('event');

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

	/**
	 * Get a record on StudentPoint.
	 * @param $id
	 * @return mixed
	 */
	public function viewStudentPoint($id){

		$student_point = new StudentPoint();

		$student_point = $student_point->with('event');
		$student_point = $student_point->find($id);
		return $student_point;

	}

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */

	public function updateStudentPoint($id,$data){

		try{

			return StudentPoint::find($id)
				->update($data);

		}catch (Exception $e){

			return $e->getMessage();
		}
	}

}


