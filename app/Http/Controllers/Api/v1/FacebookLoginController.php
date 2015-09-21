<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\FacebookLoginRequest;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use PhpSpec\Exception\Exception;


class FacebookLoginController extends ApiController {

	/**
	 * REGISTRATION
	 */

	/*
	 * Get required variables
	 *
	 *
	 * USER
	 * 	facebook_app_id
	 *	email
	 *	name -- combined with first_name and last_name
	 * 	user_type
	 *
	 * STUDENT
	 * 	first_name
	 * 	last_name
	 * 	gender
	 * 	birth_date
	 * 	country_id
	 *
	 * CLIENT
	 * 	first_name
	 * 	last_name
	 * 	client_role
	 * 	country_id
	 *
	 */

	protected $user;

	protected $student;

	protected $client;

	public function __construct(
		UserRepositoryInterface $userRepositoryInterface,
		StudentRepositoryInterface $studentRepositoryInterface,
		ClientRepositoryInterface $clientRepositoryInterface
	){

		$this->student = $studentRepositoryInterface;

		$this->client = $clientRepositoryInterface;

	}

	/**
	 * Through Facebook registration for Students and Client.
	 */
	public function facebookRegistration(FacebookLoginRequest $request){

		$user_type = $request->only('user_type');

		$student_data = $request->only(
			'facebook_app_id',
			'email',
			'user_type',
			'first_name',
			'last_name',
			'gender',
			'birth_date',
			'country_id',
			'state',
			'city'
		);

		$client_data = $request->only(
			'facebook_app_id',
			'first_name',
			'last_name',
			'email',
			'user_type',
			'birth_date',
			'client_role',
			'street_address',
			'city',
			'state',
			'country_id',
			'zip'
		);

		switch ($user_type['user_type']){

			case config('futureed.student'):

				//Registration of Student.
				return $this->respondWithData($this->student->addStudentFromFacebook($student_data));

				break;

			case config('futureed.client'):

				//Registration for Client.
				return $this->respondWithData($this->client->addClientFromFacebook($client_data));

				break;
		}

	}

}
