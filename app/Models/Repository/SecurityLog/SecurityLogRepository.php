<?php

namespace FutureEd\Models\Repository\SecurityLog;


use FutureEd\Models\Core\SecurityLog;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class SecurityLogRepository implements SecurityLogRepositoryInterface{

	use LoggerTrait;

	/**
	 * Get list of security logs.
	 * @param $criteria
	 * @param $offset
	 * @param $limit
	 * @return array
	 */
	public function getSecurityLogs($criteria, $offset, $limit){

		DB::beginTransaction();

		try {
			$log = new SecurityLog();

			if (isset($criteria['user_id'])) {

				$log = $log->userId($criteria['user_id']);
			}

			if (isset($criteria['username'])) {

				$log = $log->username($criteria['username']);
			}

			if (isset($criteria['client_ip'])) {

				$log = $log->clientIp($criteria['client_ip']);
			}

			if (isset($criteria['client_port'])) {

				$log = $log->clientPort($criteria['client_port']);
			}

			if (isset($criteria['proxy_ip'])) {

				$log = $log->proxyIp($criteria['proxy_ip']);
			}

			if (isset($criteria['client_user_agent'])) {

				$log = $log->clientUserAgent($criteria['client_user_agent']);
			}

			if (isset($criteria['url'])) {

				$log = $log->url($criteria['url']);
			}

			if (isset($criteria['result_response'])) {

				$log = $log->resultResponse($criteria['result_response']);
			}

			if (isset($criteria['data_size_transferred'])) {

				$log = $log->dataSizeTransferred($criteria['data_size_transferred']);
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
	 * Add security log.
	 * @param $data
	 * @return int|static
	 */
	public function addSecurityLogs($data){

		DB::beginTransaction();

		try{

			$response =  SecurityLog::create($data);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());


			return 0;

		}
		DB::commit();

		return $response;

	}

}