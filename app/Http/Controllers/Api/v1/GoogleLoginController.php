<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Http\Requests\Api\GoogleLoginRequest;

class GoogleLoginController extends Controller {

	/**
	 * REGISTRATION
	 */
	/*
	 * Get required variables
	 *
	 *
	 * USER
	 * 	google_app_id
	 *	email
	 *	name -- combined with first_name and last_name
	 * 	user_type
	 *
	 * STUDENT
	 * 	first_name
	 * 	last_name
	 * 	gender
	 * 	birth_date
	 *
	 * CLIENT
	 * 	first_name
	 * 	last_name
	 * 	client_role
	 *
	 */

	protected $student;

	protected $client;

	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		ClientRepositoryInterface $clientRepositoryInterface
	){
		$this->student = $studentRepositoryInterface;

		$this->client = $clientRepositoryInterface;
	}

	public function googleRegistration(GoogleLoginRequest $request){

		$user_type = $request->only('user_type');

		$student = $request->only(
			'google_app_id',
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

		$client = $request->only(
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

		switch($user_type['user_type']){

			case config('futureed.student'):

				//Registration of Student
				break;

			case config('futureed.client'):

				//Registration of Client.
				break;
		}

	}

}
