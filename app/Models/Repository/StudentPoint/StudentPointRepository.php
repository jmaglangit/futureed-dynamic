<?php namespace FutureEd\Models\Repository\StudentPoint;

use FutureEd\Models\Core\StudentPoint;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class StudentPointRepository implements StudentPointRepositoryInterface{

	use LoggerTrait;

	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addStudentPoint($data){

		DB::beginTransaction();

		try {

			$student_point = StudentPoint::create($data);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

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

		DB::beginTransaction();

		try {
			$student_point = new StudentPoint();
			$student_point = $student_point->with('event');

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $student_point->count();

			} else {

				if (count($criteria) > 0) {
					if (isset($criteria['student_id'])) {
						$student_point = $student_point->studentId($criteria['student_id']);
					}
				}

				$count = $student_point->count();

				if ($limit > 0 && $offset >= 0) {
					$student_point = $student_point->offset($offset)->limit($limit);
				}

			}

			$response = ['total' => $count, 'records' => $student_point->get()->toArray()];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get a record on StudentPoint.
	 * @param $id
	 * @return mixed
	 */
	public function viewStudentPoint($id){

		DB::beginTransaction();

		try {
			$student_point = new StudentPoint();

			$student_point = $student_point->with('event');
			$student_point = $student_point->find($id);
		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $student_point;
	}

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */
	public function updateStudentPoint($id,$data){

		DB::beginTransaction();

		try{

			$response = StudentPoint::find($id)
				->update($data);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

}


