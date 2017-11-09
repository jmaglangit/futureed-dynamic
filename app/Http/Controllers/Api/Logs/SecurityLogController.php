<?php namespace FutureEd\Http\Controllers\Api\Logs;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\SecurityLog\SecurityLogRepositoryInterface;
use Illuminate\Support\Facades\Input;

class SecurityLogController extends LogController {


	protected $security_log;

	public function __construct(
		SecurityLogRepositoryInterface $securityLogRepositoryInterface
	){

		$this->security_log = $securityLogRepositoryInterface;
	}

	/**
	 * Display a listing of security logs.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = array();
		$limit = 0;
		$offset = 0;

		if(Input::get('user_id')) {
			$criteria['user_id'] = Input::get('user_id');
		}

		if(Input::get('username')) {
			$criteria['username'] = Input::get('username');
		}

		if(Input::get('client_ip')) {
			$criteria['client_ip'] = Input::get('client_ip');
		}

		if(Input::get('client_port')) {
			$criteria['client_port'] = Input::get('client_port');
		}

		if(Input::get('proxy_ip')) {
			$criteria['proxy_ip'] = Input::get('proxy_ip');
		}

		if(Input::get('client_user_agent')) {
			$criteria['client_user_agent'] = Input::get('client_user_agent');
		}

		if(Input::get('url')) {
			$criteria['url'] = Input::get('url');
		}

		if(Input::get('result_response')) {
			$criteria['result_response'] = Input::get('result_response');
		}

		if(Input::get('data_size_transferred')) {
			$criteria['data_size_transferred'] = Input::get('data_size_transferred');
		}

		if(Input::get('log_type')) {
			$criteria['log_type'] = Input::get('log_type');
		}

		if(Input::get('log_id')) {
			$criteria['log_id'] = Input::get('user_id');
		}

		if(Input::get('status')) {
			$criteria['status'] = Input::get('status');
		}

		if(Input::get('date_start')) {
			$criteria['date_start'] = Input::get('date_start');
		}

		if(Input::get('date_end')) {
			$criteria['date_end'] = Input::get('date_end');
		}

		if(Input::get('offset')) {
			$offset = Input::get('offset');
		}

		if(Input::get('limit')) {
			$limit = Input::get('limit');
		}

		$log_record = $this->security_log->getSecurityLogs($criteria,$offset,$limit);


		$additional_information = [];


		$column_header = [
			'user_id' => 'User Id',
			'username' => 'Username',
			'client_ip' => 'IP Address',
			'client_port' => 'Port',
			'proxy_ip' => 'Proxy',
			'client_user_agent' => 'Agent Used',
			'url' => 'URL',
			'result_response' => 'HTTP Response',
			'data_size_transferred' => 'Transferred Data',
			'log_type' => 'Log Type',
			'log_id' => 'Log Reference',
			'Status' => 'Status'
		];




		$rows = $log_record;

		return $this->respondLogData($additional_information,$column_header,$rows);



	}



}
