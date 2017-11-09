<?php

namespace FutureEd\Models\Repository\UserLog;


use FutureEd\Models\Core\UserLog;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class UserLogRepository implements UserLogRepositoryInterface{

	use LoggerTrait;

	public function getUserLog($id){

		return UserLog::find($id);
	}

	/**
	 * Get list of user logs filter by criteria.
	 * @param $criteria
	 * @param $offset
	 * @param $limit
	 * @return array
	 */
	public function getUserLogs($criteria, $offset, $limit){

		/**
		 * user_id equals
		 * username liked
		 * email liked
		 * name liked
		 * user_type equals
		 * page_accessed liked
		 * api_accessed liked
		 * result_response equal
		 * status equals
		 * date_start
		 * date_end
		 */

		DB::beginTransaction();

		try {

			$log = new UserLog();

			if (isset($criteria['user_id'])) {

				$log = $log->userId($criteria['user_id']);

			}

			if (isset($criteria['username'])) {

				$log = $log->username($criteria['username']);
			}

			if (isset($criteria['email'])) {

				$log = $log->email($criteria['email']);
			}

			if (isset($criteria['name'])) {

				$log = $log->name($criteria['name']);
			}

			if (isset($criteria['user_type'])) {

				$log = $log->userType($criteria['user_type']);
			}

			if (isset($criteria['page_accessed'])) {

				$log = $log->pageAccessed($criteria['page_accessed']);
			}

			if (isset($criteria['api_accessed'])) {

				$log = $log->apiAccessed($criteria['api_accessed']);
			}

			if (isset($criteria['result_response'])) {

				$log = $log->resultResponse($criteria['result_response']);
			}

			if (isset($criteria['status'])) {

				$log = $log->status($criteria['status']);
			}

			if (isset($criteria['date_start'])) {

				$log = $log->dateStart($criteria['date_start']);
			}

			if (isset($criteria['date_end'])) {

				$log = $log->dateEnd($criteria['date_end']);
			}

			$count = $log->count();

			if ($limit > 0 && $offset >= 0) {
				$log = $log->offset($offset)->limit($limit);;
			}

			$response = [
				'total' => $count,
				'record' => $log->get()->toArray()
			];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add user log.
	 * @param $data
	 */
	public function addUserLog($data){

		DB::beginTransaction();

		try{

			$response = UserLog::create($data);

		}catch(\Exception $e){

			$this->errorLog($e->getMessage());

			DB::rollback();

			return false;
		}

		DB::commit();

		return $response;


	}

}