<?php

namespace FutureEd\Models\Repository\Tip;

use Carbon\Carbon;
use FutureEd\Models\Core\Tip;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;


class TipRepository implements TipRepositoryInterface{

	use LoggerTrait;

	/**
	 * Create record
	 * @param $data
	 * @return bool|static
	 */
	public function addTip($data){

		DB::beginTransaction();

		try {

			$response = Tip::create($data);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array|bool
	 */
	public function getTips($criteria = array(), $limit = 0, $offset = 0){

		DB::beginTransaction();

		try {

			$tip = new Tip();

			$tip = $tip->with('subject', 'module', 'subjectarea')->where('tip_status', '!=', 'Rejected');

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $tip->count();

			} else {


				if (count($criteria) > 0) {

					//for tip_status
					if (isset($criteria['status'])) {

						$tip = $tip->tipStatus($criteria['status']);

					}

					//check for link_type
					if (isset($criteria['link_type'])) {

						$tip = $tip->linkType($criteria['link_type']);
					}

					//check relation to subject
					if (isset($criteria['subject'])) {

						$tip = $tip->subjectName($criteria['subject']);
					}

					//check relation to module
					if (isset($criteria['module'])) {

						$tip = $tip->moduleName($criteria['module']);
					}

					//check relation to subject_area
					if (isset($criteria['area'])) {

						$tip = $tip->subjectAreaName($criteria['area']);
					}

				}

				$count = $tip->count();

				if ($limit > 0 && $offset >= 0) {
					$tip = $tip->offset($offset)->limit($limit);
				}

			}
			$tip = $tip->orderBy('created_at', 'desc');
			$response = ['total' => $count, 'records' => $tip->get()->toArray()];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @return bool|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|static
	 */
	public function viewTip($id){

		DB::beginTransaction();

		try {
			$tip = new Tip();

			$tip = $tip->with('subject', 'module', 'subjectarea', 'student');

			$response = $tip->find($id);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * @param $id
	 * @param $data
	 * @return bool|int
	 */
	public function updateTip($id, $data){

		DB::beginTransaction();

		try{

			$response = Tip::find($id)
						->update($data);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @return bool|null
	 */
	public function deleteTip($id){

		DB::beginTransaction();

		try {

			$tip = Tip::find($id);

			$response = !is_null($tip) ? $tip->delete() : false;

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * List of tips under a class
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array|bool
	 */
	public function viewClassTips($criteria = array(), $limit = 0, $offset = 0){

		DB::beginTransaction();

		try{
			$tip = new Tip();

			$tip = $tip->with('subject', 'module', 'subjectarea', 'student')->where('tip_status', '!=', 'Rejected');

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $tip->count();

			} else {

				if (count($criteria) > 0) {

					//for class_id
					if (isset($criteria['class_id'])) {

						$tip = $tip->classId($criteria['class_id']);
					}

					//for module_id
					if (isset($criteria['module_id'])) {

						$tip = $tip->moduleId($criteria['module_id']);
					}

					//check for link_type
					if (isset($criteria['link_type'])) {

						$tip = $tip->linkType($criteria['link_type']);
					}

					//check for link_id
					if (isset($criteria['link_id'])) {

						$tip = $tip->linkId($criteria['link_id']);
					}

					//for title
					if (isset($criteria['title'])) {

						$tip = $tip->title($criteria['title']);
					}


					//for tip_status
					if (isset($criteria['tip_status'])) {

						$tip = $tip->tipStatus($criteria['tip_status']);

					}

					//for status
					if (isset($criteria['status'])) {

						$tip = $tip->status($criteria['status']);
					}

					//relation to student query creators name
					if (isset($criteria['created'])) {

						$tip = $tip->name($criteria['created']);

					}

					//check relation to subject
					if (isset($criteria['subject'])) {

						$tip = $tip->subjectName($criteria['subject']);
					}

					//check relation to subject_area
					if (isset($criteria['area'])) {

						$tip = $tip->subjectAreaName($criteria['area']);
					}

				}

				$count = $tip->count();

				if ($limit > 0 && $offset >= 0) {
					$tip = $tip->offset($offset)->limit($limit);

				}

			}
			$tip = $tip->orderBy('created_at', 'desc');

			$response = ['total' => $count, 'records' => $tip->get()->toArray()];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

        DB::commit();

        return $response;
	}

	/**
	 * @param $class_id
	 * @return bool
	 */
	public function viewCurrentTips($class_id){

		DB::beginTransaction();

		try{
			$tip = new Tip();

			$tip = $tip->with('subject', 'module', 'subjectarea', 'student')->accepted();
			$tip = $tip->general()->classId($class_id);
			$tip = $tip->orderBy('created_at', 'desc')->take(config('futureed.tip_take'));
			$response = $tip->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

        DB::commit();

        return $response;
	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @return bool
	 */
	public function getStudentActiveTips($student_id, $subject_id){
		//
		//select
		//t.id, t.class_id,t.student_id
		//from tips t
		//left join classrooms c on c.id=t.class_id
		//left join orders o on o.order_no=c.order_no
		//where
		//t.student_id = 3
		//and t.subject_id = 3
		//and o.date_start <= now() and o.date_end >= now()
		//;

		DB::beginTransaction();

		try {

			$response = Tip::select('tips.*')->leftJoin('classrooms as c', 'c.id', '=', 'tips.class_id')
				->leftJoin('orders as o', 'o.order_no', '=', 'c.order_no')
				->where('tips.student_id', $student_id)
				->where('tips.subject_id', $subject_id)
				->where('o.date_start', '<=', Carbon::now())
				->where('o.date_end', '>=', Carbon::now())
				->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}




	

}