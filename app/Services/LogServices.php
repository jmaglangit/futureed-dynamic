<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 10/8/15
 * Time: 6:23 PM
 */

namespace FutureEd\Services;


use FutureEd\Models\Core\SecurityLog;
use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Models\Repository\AdminLog\AdminLogRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\SecurityLog\SecurityLogRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Models\Repository\UserLog\UserLogRepositoryInterface;

class LogServices {

	protected $admin;

	protected $client;

	protected $student;

	protected $user_log;

	protected $admin_log;

	protected $security_log;

	public function __construct(
		AdminRepositoryInterface $adminRepositoryInterface,
		ClientRepositoryInterface $clientRepositoryInterface,
		StudentRepositoryInterface $studentRepositoryInterface,
		UserLogRepositoryInterface $userLogRepositoryInterface,
		AdminLogRepositoryInterface $adminLogRepositoryInterface,
		SecurityLogRepositoryInterface $securityLogRepositoryInterface
	){
		$this->admin = $adminRepositoryInterface;

		$this->client = $clientRepositoryInterface;

		$this->student = $studentRepositoryInterface;

		$this->user_log = $userLogRepositoryInterface;

		$this->admin_log = $adminLogRepositoryInterface;

		$this->security_log = $securityLogRepositoryInterface;
	}

	/**
	 * Add admin log.
	 * @param $data
	 */
	public function addAdminLog($data){

		$admin_data = $this->admin->getAdmin($data['id'],$data['role']);

		$log_data = [
			'user_id' => $admin_data->user_id,
			'username' =>$admin_data->user->username,
			'email' => $admin_data->user->email,
			'name' => $admin_data->first_name.' '.$admin_data->last_name,
			'admin_type' => $admin_data->admin_role,
			'page_accessed' => $data['page_accessed'],
			'api_accessed' => $data['api_accessed'],
			'result_response' => $data['result_response'],
			'created_by' => $admin_data->user_id,
			'updated_by' => $admin_data->user_id
		];

		return $this->admin_log->addAdminLog($log_data);

	}

	/**
	 * Add user log.
	 * @param $data
	 */
	public function addUserLog($data){

		// pass data user_id,page_accessed,api_accessed,result_response
		/*
					user_id
					username
					email
					name
					admin_type
					page_accessed
					api_accessed
					result_response
					status
					created_by
					updated_by
					*/
		//get user information based on user_id
		//check what type of user.


		if(isset($data['type'])){

			switch($data['type']){

				case config('futureed.student'):

					$user_data = $this->student->getStudent($data['id']);
					break;
				case config('futureed.client'):

					$user_data = $this->client->getClientDetails($data['id']);
					break;
				default:
					break;
			}

		}

		$log_data = [
			'user_id' => (isset($user_data->user_id)) ? $user_data->user_id : 0,
			'username' =>(isset($user_data->user->username)) ? $user_data->user->username : $data['username'],
			'email' => (isset($user_data->user->email)) ? $user_data->user->email : $data['username'],
			'name' => (isset($user_data)) ? $user_data->first_name.' '.$user_data->last_name : $data['username'],
			'user_type' => (isset($data['type'])) ? $data['type'] : config('futureed.client'),
			'page_accessed' => (isset($data['page_accessed'])) ? $data['page_accessed'] : 'NA',
			'api_accessed' => (isset($data['api_accessed'])) ? $data['api_accessed'] : 'NA',
			'result_response' => (isset($data['result_response'])) ? $data['result_response'] : 0,
			'created_by' => (isset($user_data->user_id)) ? $user_data->user_id : 0,
			'updated_by' => (isset($user_data->user_id)) ? $user_data->user_id : 0
		];

		return $this->user_log->addUserLog($log_data);


	}

	/**
	 * Add security log.
	 * @param $data
	 */
	public function addSecurityLog($data){

		$data = array_merge($data,[
			'created_by' => $data['user_id'],
			'updated_by' => $data['user_id']
		]);

		return $this->security_log->addSecurityLogs($data);
	}


}