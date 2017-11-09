<?php

namespace FutureEd\Models\Repository\StudentBadge;

use FutureEd\Models\Core\StudentBadge;
use FutureEd\Models\Traits\LoggerTrait;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;


class StudentBadgeRepository implements StudentBadgeRepositoryInterface{

	use LoggerTrait;

	/**
	 * Gets list of StudentBadges.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getStudentBadges($criteria = array(), $limit = 0, $offset = 0){

		DB::beginTransaction();

		try {
			$student_badge = new StudentBadge();

			$student_badge = $student_badge->with('badges');

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $student_badge->count();

			} else {


				if (count($criteria) > 0) {

					//check scope to student_id
					if (isset($criteria['student_id'])) {

						$student_badge = $student_badge->studentId($criteria['student_id']);
					}

				}

				$count = $student_badge->count();

				if ($limit > 0 && $offset >= 0) {
					$student_badge = $student_badge->offset($offset)->limit($limit);
				}

			}

			$response = ['total' => $count, 'records' => $student_badge->get()->toArray()];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */
	public function updateStudentBadge($id,$data){

		DB::beginTransaction();

		try{

			$response = StudentBadge::find($id)
				->update($data);

		}catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get a record on StudentBadge.
	 * @param $id
	 * @return mixed
	 */
	public function viewStudentBadge($id){

		DB::beginTransaction();

		try {

			$student_badge = new StudentBadge();
			$student_badge = $student_badge->with('badges');
			$student_badge = $student_badge->find($id);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $student_badge;
	}

	/**
	 * Delete StudentBadge.
	 * @param $id
	 * @return mixed
	 */
	public function deleteStudentBadge($id){

		DB::beginTransaction();

		try{

			$response = StudentBadge::find($id)
				->delete();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addStudentBadge($data){

		DB::beginTransaction();

		try {

			$student_badge = StudentBadge::create($data);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $student_badge;
	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @param $age_group_id
	 * @return bool
	 */
	public function getStudentBadge($student_id, $subject_id, $age_group_id){

		DB::beginTransaction();
		try{

			$response = StudentBadge::studentId($student_id)
				->subjectId($subject_id)
				->ageGroupId($age_group_id)
				->get();

		}catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


}