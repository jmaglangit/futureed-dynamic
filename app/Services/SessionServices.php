<?php namespace FutureEd\Services;


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
		StudentRepositoryInterface $studentRepositoryInterface
	){

		$this->student = $studentRepositoryInterface;
		$this->client = $clientRepositoryInterface;
		$this->admin = $adminRepositoryInterface;
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


}