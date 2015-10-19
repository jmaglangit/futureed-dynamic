<?php namespace FutureEd\Services;


use Carbon\Carbon;
use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Session;

class SessionServices {

	/**
	 * @var user
	 */
	protected $user;

	protected $user_repo;

	/**
	 * @var student
	 */
	protected $student;

	/**
	 * @var client
	 */
	protected $client;

	/**
	 * @var admin
	 */
	protected $admin;

	/**
	 * @param UserRepositoryInterface $userRepositoryInterface
	 */
	public function __construct(
		AdminRepositoryInterface $adminRepositoryInterface,
		ClientRepositoryInterface $clientRepositoryInterface,
		StudentRepositoryInterface $studentRepositoryInterface,
		UserRepositoryInterface $userRepositoryInterface

	){

		$this->student = $studentRepositoryInterface;
		$this->client = $clientRepositoryInterface;
		$this->admin = $adminRepositoryInterface;
		$this->user_repo = $userRepositoryInterface;
	}

	/**
	 * @param user $user
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}

	/**
	 * @return user $user
	 */
	public function getUser(){

		return $this->user;
	}

	/**
	 * Get User information by User type
	 * @param $id
	 * @param $user_type
	 * @return bool
	 */
	public function getUserInformation($id, $user_type){

		switch($user_type){

			case config('futureed.student'):

				//get user id of student.
				$return =  $this->student->getStudent($id);
				break;

			case config('futureed.client'):

				//get user id of client.
				$return =   $this->client->getClientDetails($id);
				break;

			case config('futureed.admin'):

				//get user id of admin
				$return =   $this->admin->getAdminDetail($id);
				break;

			default:
				return false;
		}

		//set user
		$this->setUser($return->toArray());

		return $this->getUser();

	}

	//Add to session key User
	public function addSessionUser(){

		$user = $this->getUser();

		Session::put('current_user',$user['user_id']);

	}

	//check user login if available.
	public function addSessionToken($user_data){

		//user_data - user_id, token.
		//get session by id
		$stored_session = $this->user_repo->getSessionToken($user_data['user_id']);


//	dd($stored_session->last_activity, Carbon::now()->diffInSeconds(Carbon::parse($stored_session->last_activity)));

		if(!$stored_session->session_token){

			//update user with token
			return $this->user_repo->updateSessionToken($user_data);

		} elseif($stored_session->session_token <> $user_data['session_token']
			&&  Carbon::now()->diffInHours(Carbon::parse($stored_session->last_activity)) > 2 ){
			//	if exist compare token  and last_activity <= 2hrs/ session expiry.

			//update user with token
			return $this->user_repo->updateSessionToken($user_data);

		} elseif($stored_session->session_token == $user_data['session_token']) {

			//update last_activity to now
			return $this->user_repo->updateSessionToken($user_data);

		} else {

			return false;
		}


	}


}