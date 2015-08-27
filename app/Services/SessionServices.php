<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;

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
		UserRepositoryInterface $userRepositoryInterface,
		AdminRepositoryInterface $adminRepositoryInterface,
		ClientRepositoryInterface $clientRepositoryInterface,
		StudentRepositoryInterface $studentRepositoryInterface
	){

		$this->user = $userRepositoryInterface;
		$this->student = $studentRepositoryInterface;
		$this->client = $clientRepositoryInterface;
		$this->admin = $adminRepositoryInterface;
	}

	/**
	 * Get User information by User type
	 * @param $id
	 * @param $user_type
	 */
	public function getUser($id, $user_type){

		switch($user_type){

			case config('futureed.student'):

				//get user id of student.
				return $this->student->getStudent($id);
				break;

			case config('futureed.client'):
				//get user id of client.


				break;
			case config('futureed.admin'):
				//get user id of admin
				break;
			default:
				return false;

		}

	}

	//Add to session key User


}