<?php namespace FutureEd\Http\Controllers\Api\Logs;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\UserLog\UserLogRepositoryInterface;
use Illuminate\Support\Facades\Input;

class UserLogController extends LogController {

	protected $user_log;

	public function __construct(
		UserLogRepositoryInterface $userLogRepositoryInterface
	){

		$this->user_log = $userLogRepositoryInterface;
	}
	/**
	 * Display a listing of user logs.
	 *
	 * @return Response
	 */
	public function index()
	{

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

		$criteria = array();
		$limit = 0;
		$offset = 0;

		if(Input::get('user_id')) {
			$criteria['user_id'] = Input::get('user_id');
		}

		if(Input::get('username')) {
			$criteria['username'] = Input::get('username');
		}

		if(Input::get('email')) {
			$criteria['email'] = Input::get('email');
		}

		if(Input::get('name')) {
			$criteria['name'] = Input::get('name');
		}

		if(Input::get('user_type')) {
			$criteria['user_type'] = Input::get('user_type');
		}

		if(Input::get('page_accessed')) {
			$criteria['page_accessed'] = Input::get('page_accessed');
		}

		if(Input::get('api_accessed')) {
			$criteria['api_accessed'] = Input::get('api_accessed');
		}

		if(Input::get('result_response')) {
			$criteria['result_response'] = Input::get('result_response');
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

		if(Input::get('limit')) {
			$limit = Input::get('limit');
		}

		if(Input::get('offset')) {
			$offset = Input::get('offset');
		}


		$log_record = $this->user_log->getUserLogs($criteria,$offset,$limit);

		$additional_information = [];


		$column_header = [
			'user_id' => 'User ID',
			'username' => 'Username',
			'email' => 'Email',
			'name' => 'Name',
			'user_type' => 'User Type',
			'page_accessed' => 'Page Accessed',
			'api_accessed' => 'API Accessed',
			'result_response' => 'Response Status',
			'status' => 'Log Status'
		];

		$rows = $log_record;

		return $this->respondLogData($additional_information, $column_header, $rows);




	}



}
