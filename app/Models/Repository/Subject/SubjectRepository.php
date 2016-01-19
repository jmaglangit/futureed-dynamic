<?php
namespace FutureEd\Models\Repository\Subject;

use FutureEd\Models\Core\Subject;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class SubjectRepository implements SubjectRepositoryInterface {

	use LoggerTrait;
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

		DB::beginTransaction();

		try {
			$subjects = new Subject();

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $subjects->count();

			} else {

				if (count($criteria) > 0) {
					if (isset($criteria['name'])) {
						$subjects = $subjects->with('areas')->name($criteria['name']);
					}


					if (isset($criteria['status'])) {
						$subjects = $subjects->with('areas')->status($criteria['status']);
					}
				}

				$count = $subjects->count();

				if ($limit > 0 && $offset >= 0) {
					$subjects = $subjects->with('areas')->offset($offset)->limit($limit);;
				}

			}

			$subjects = $subjects->with('areas')->orderBy('name', 'asc');

			$response = ['total' => $count, 'records' => $subjects->get()->toArray()];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add subject.
	 *
	 * @param	array	$subject
	 *
	 * @return boolean
	 */
	public function addSubject($subject) {

		DB::beginTransaction();

		try {
		
			$subject = Subject::create($subject);
			
		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();
		
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

		DB::beginTransaction();

		try {

			$response = Subject::with('areas')->find($id);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update subject.
	 *
	 * @param    int $id
	 * @param $data
	 * @return bool
	 * @internal param array $subject
	 *
	 */
	public function updateSubject($id, $data) {

		DB::beginTransaction();

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

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();
		
		return $subject;
	}

	/**
	 * Delete subject.
	 *
	 * @param    int $id
	 * @return bool
	 * @internal param array $subject
	 *
	 */
	public function deleteSubject($id) {

		DB::beginTransaction();

		try {
		
			$subject = Subject::find($id);
						
			$response = !is_null($subject) ? $subject->delete() : false;
			
		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

}