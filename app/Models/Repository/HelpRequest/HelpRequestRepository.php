<?php namespace FutureEd\Models\Repository\HelpRequest;

use FutureEd\Models\Core\HelpRequest;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class HelpRequestRepository implements HelpRequestRepositoryInterface{
	use LoggerTrait;

	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addHelpRequest($data){
		DB::beginTransaction();

		try{
			$response = HelpRequest::create($data)->toArray();
		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Retrieve specific record in storage.
	 * @param $id
	 * @return array|null|string
	 */

	public function getHelpRequest($id){
		DB::beginTransaction();

		try{
			$result = HelpRequest::with('classroom','module','subject','subjectArea','student')->find($id);
			$response = is_null($result) ? null : $result;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Search or list records
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 *
	 */
	public function getHelpRequests($criteria = array(), $limit = 0, $offset = 0){
		DB::beginTransaction();

		try{
			$query = new HelpRequest();

			$query = $query->NotRejected();

			$query = $query->with('classroom','module','subject','subjectArea','student');

			if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {
				$count = $query->count();
				$query = $query->orderBy('title', 'asc');
			} else {
				if(count($criteria) > 0) {
					if(isset($criteria['module'])) {
						$query = $query->moduleName($criteria['module']);
					}
					if(isset($criteria['subject'])) {
						$query = $query->subjectName($criteria['subject']);
					}
					if(isset($criteria['subject_area'])) {
						$query = $query->subjectAreaName($criteria['subject_area']);
					}
					if(isset($criteria['status'])) {
						$query = $query->status($criteria['status']);
					}
					if(isset($criteria['student'])) {
						$query = $query->studentName($criteria['student']);
					}
					if(isset($criteria['title'])) {
						$query = $query->title($criteria['title']);
					}
					if(isset($criteria['link_type'])) {
						$query = $query->linkType($criteria['link_type']);
					}
					if(isset($criteria['order_by_date'])) {
						$query = $query->orderBy('created_at', 'desc');
					} else{
						$query = $query->orderBy('title', 'asc');
					}

					if(isset($criteria['student_id']) && isset($criteria['help_request_type'])){
						if($criteria['help_request_type'] == 'Own'){
							$query = $query->ownRequest($criteria['student_id']);
						}else{
							$query = $query->otherRequest($criteria['student_id']);
							$query = $query->requestStatus(config('futureed.help_request_status_accepted'));
						}
					}

					if(isset($criteria['subject_id'])) {
						$query = $query->subjectId($criteria['subject_id']);
					}

					if(isset($criteria['class_id'])) {
						$query = $query->classId($criteria['class_id']);
					}

					if(isset($criteria['module_id'])) {
						$query = $query->moduleId($criteria['module_id']);
					}

					if(isset($criteria['request_status'])) {
						$query = $query->requestStatus($criteria['request_status']);
					}
					if(isset($criteria['link_id'])) {
						$query = $query->linkId($criteria['link_id']);
					}
					if(isset($criteria['question_status'])) {
						$array_question_status = explode(',', $criteria['question_status']);
						$query = $query->questionStatus($array_question_status);
					}

				}

				$count = $query->count();

				if($limit > 0 && $offset >= 0) {
					$query = $query->offset($offset)->limit($limit);
				}
			}
			$query = $query->orderBy('created_at', 'desc');

			$response = ['total' => $count, 'records' => $query->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update specific record
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */
	public function updateHelpRequest($id,$data){
		DB::beginTransaction();

		try{
			$result = HelpRequest::find($id);
			$response = !is_null($result) ? $result->update($data) : false;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Delete specific record.
	 * @param  $id
	 * @return boolean
	 */
	public function deleteHelpRequest($id){
		DB::beginTransaction();

		try{
			$result = HelpRequest::find($id);
			$response = !is_null($result) ? $result->delete() : false;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}