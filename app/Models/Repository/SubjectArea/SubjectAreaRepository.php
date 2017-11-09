<?php
namespace FutureEd\Models\Repository\SubjectArea;

use FutureEd\Models\Core\SubjectArea;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class SubjectAreaRepository implements SubjectAreaRepositoryInterface {

	use LoggerTrait;

	/**
	 * Get a listing of subject areas by subject id.
	 *
	 * @param	int		$subject_id
	 *
	 * @return array
	 */	
	public function getAreasBySubjectId($subject_id) {

		DB::beginTransaction();

		try {

			$response = SubjectArea::subjectId($subject_id)->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
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

		DB::beginTransaction();

		try {
			$subject_areas = new SubjectArea();

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $subject_areas->count();

			} else {

				if (count($criteria) > 0) {
					if (isset($criteria['name'])) {
						$subject_areas = $subject_areas->name($criteria['name']);
					}

					if (isset($criteria['subject_id'])) {
						$subject_areas = $subject_areas->subjectid($criteria['subject_id']);
					}


				}

				$count = $subject_areas->count();

				if ($limit > 0 && $offset >= 0) {
					$subject_areas = $subject_areas->offset($offset)->limit($limit);;
				}

			}
			$subject_areas = $subject_areas->with('subject')->orderBy('name', 'desc');
			$subject_areas = $subject_areas->orderBy('name', 'asc');

			$response = ['total' => $count, 'records' => $subject_areas->get()->toArray()];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add subject area.
	 *
	 * @param	array	$subject_area
	 *
	 * @return boolean
	 */
	public function addSubjectArea($subject_area) {

		DB::beginTransaction();

		try {
		
			$response = SubjectArea::create($subject_area);
			
		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
		
	}

	/**
	 * Get subject area.
	 *
	 * @param	int	$id
	 *
	 * @return Resource
	 */
	public function getSubjectArea($id) {

		DB::beginTransaction();

		try {

			$response = SubjectArea::find($id);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
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

		DB::beginTransaction();

		try {
		
			$subject_area = SubjectArea::find($id);
			
			unset($data['code']);
			
			$subject_area->update($data);
			
		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();
		
		return $subject_area;
		
	}

	/**
	 * Delete subject area.
	 *
	 * @param    int $id
	 * @return bool
	 * @internal param array $subject
	 *
	 */
	public function deleteSubjectArea($id) {

		DB::beginTransaction();

		try {
		
			$subject_area = SubjectArea::find($id);
						
			$response = !is_null($subject_area) ? $subject_area->delete() : false;
			
		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
				
	}

}