<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\FacebookLoginRequest;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Services\StudentServices;
use FutureEd\Services\UserServices;


class FacebookLoginController extends ApiController {

	/**
	 * @var StudentRepositoryInterface
	 */
	protected $student;

	protected $student_service;

	protected $user_service;

	/**
	 * @var ClientRepositoryInterface
	 */
	protected $client;

	/**
	 * @param StudentRepositoryInterface $studentRepositoryInterface
	 * @param ClientRepositoryInterface $clientRepositoryInterface
	 */
	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		StudentServices $studentServices,
		ClientRepositoryInterface $clientRepositoryInterface,
		UserServices $userServices
	){

		$this->student = $studentRepositoryInterface;

		$this->student_service = $studentServices;

		$this->client = $clientRepositoryInterface;

		$this->user_service = $userServices;
	}

	/**
	 * Through Facebook registration for Students and Client.
	 * @param FacebookLoginRequest $request
	 * @return mixed
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
			'city',
			'grade_code'
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
				$response = $this->student->addStudentFromFacebook($student_data);

				return ($response) ?
					$this->respondWithData(['id' => $response->id]) : $this->respondErrorMessage(7000) ;

				break;

			case config('futureed.client'):

				//Registration for Client.
				$response = $this->client->addClientFromFacebook($client_data);

				return ($response) ?
					$this->respondWithData(['id' => $response->id]) : $this->respondErrorMessage(7000) ;

				break;

			default:

				//TODO: Log issue if not on option.

				return $this->respondErrorMessage(2003);

				break;
		}

	}

	public function facebookLogin(FacebookLoginRequest $request){

		$user_type = $request->only('user_type');

		$app_id = $request->only('facebook_app_id');

		switch($user_type['user_type']){

			case config('futureed.student'):

				//Student login.

				//get student id by facebook_app_id
				$student_details =  $this->student->getStudentByFacebook($app_id);

				return $this->respondWithData(
					$this->student_service->getStudentDetails($student_details[0]->id)
				);

				break;

			case config('futureed.client'):

				//Client Login

				//get Client id by facebook_app_id
				$client_details = $this->client->getClientByFacebook($app_id);

				return $this->respondWithData($client_details[0]->toArray());

				break;

			default:

				//TODO: Log issue if not on option.

				return $this->respondErrorMessage(2003);

				break;
		}
	}

}
