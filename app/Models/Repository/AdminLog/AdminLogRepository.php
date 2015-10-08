<?php

namespace FutureEd\Models\Repository\AdminLog;


use FutureEd\Models\Core\AdminLog;

class AdminLogRepository implements AdminLogRepositoryInterface{

	/**
	 * Get Admin log.
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getAdminLog($id){

		return AdminLog::find($id);
	}

	/**
	 * Get list of user logs filter by criteria.
	 * @param $criteria
	 * @param $offset
	 * @param $limit
	 * @return array
	 */
	public function getAdminLogs($criteria, $offset, $limit){

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

		$log = new AdminLog();

		if(isset($criteria['user_id'])){

			$log = $log->userId($criteria['user_id']);

		}

		if(isset($criteria['username'])){

			$log = $log->username($criteria['username']);
		}

		if(isset($criteria['email'])){

			$log = $log->email($criteria['email']);
		}

		if(isset($criteria['name'])){

			$log = $log->name($criteria['name']);
		}

		if(isset($criteria['admin_type'])){

			$log = $log->adminType($criteria['admin_type']);
		}

		if(isset($criteria['page_accessed'])){

			$log = $log->pageAccessed($criteria['page_accessed']);
		}

		if(isset($criteria['api_accessed'])){

			$log = $log->apiAccessed($criteria['api_accessed']);
		}

		if(isset($criteria['result_response'])){

			$log = $log->resultResponse($criteria['result_response']);
		}

		if(isset($criteria['status'])){

			$log = $log->status($criteria['status']);
		}

		if(isset($criteria['date_start'])){

			$log = $log->dateStart($criteria['date_start']);
		}

		if(isset($criteria['date_end'])){

			$log = $log->dateEnd($criteria['date_end']);
		}

		$count = $log->count();

		if($limit > 0 && $offset >= 0) {
			$log = $log->offset($offset)->limit($limit);;
		}

		return [
			'total' => $count,
			'record' => $log->get()->toArray()
		];
	}
}