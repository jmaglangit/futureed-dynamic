<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Http\Requests\Api\GoogleLoginRequest;
use FutureEd\Services\SchoolServices;
use FutureEd\Services\StudentServices;

class GoogleLoginController extends ApiController {

	/**
	 * REGISTRATION
	 */


	protected $student;

	/**
	 * @var StudentServices
	 */
	protected $student_service;

	protected $school_service;

	/**
	 * @var ClientRepositoryInterface
	 */
	protected $client;

	/**
	 * @param StudentRepositoryInterface $studentRepositoryInterface
	 * @param StudentServices $studentServices
	 * @param ClientRepositoryInterface $clientRepositoryInterface
	 */
	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		StudentServices $studentServices,
		ClientRepositoryInterface $clientRepositoryInterface,
		SchoolServices $schoolServices
	){
		$this->student = $studentRepositoryInterface;

		$this->student_service = $studentServices;

		$this->school_service = $schoolServices;

		$this->client = $clientRepositoryInterface;
	}

	/**
	 * Google Registration
	 * @param GoogleLoginRequest $request
	 * @return mixed
	 */
	public function googleRegistration(GoogleLoginRequest $request){

		$user_type = $request->only('user_type');

		$student_data = $request->only(
			'google_app_id',
			'email',
			'user_type',
			'first_name',
			'last_name',
			'gender',
			'birth_date',
			'country_id',
			'state',
			'city',
			'grade_code',
			'username'
		);

		$client_data = $request->only(
			'google_app_id',
			'first_name',
			'last_name',
			'email',
			'user_type',
			'client_role',
			'street_address',
			'city',
			'state',
			'country_id',
			'zip',
			'username'
		);

		$school_data = $request->only(
			'school_name',
			'school_address',
			'school_city',
			'school_state',
			'school_zip',
			'contact_name',
			'contact_number',
			'school_country_id'
		);

		switch($user_type['user_type']){

			case config('futureed.student'):

				//Registration of Student
				$response = $this->student->addStudentFromGoogle($student_data);

				if($response){

					return $this->respondWithData(
						$this->student_service->getStudentDetails($response->id)
					);

				}else{

					return $this->respondErrorMessage(7000);
				}

				break;

			case config('futureed.client'):

				//Add New School
				if ($client_data['client_role'] == config('futureed.principal')) {

					// add school, return status
					$school_response = $this->school_service->addSchool($school_data);

					$client_data = array_add($client_data,'school_code',$school_response['message']);
				}

				//Registration of Client.
				$response = $this->client->addClientFromGoogle($client_data);

				if($response){

					return $this->respondWithData($response[0]->toArray());

				}else{

					return $this->respondErrorMessage(7000);
				}

				break;
		}

	}

	/**
	 * Google Login
	 * @param GoogleLoginRequest $request
	 * @return mixed
	 */
	public function googleLogin(GoogleLoginRequest $request) {

		$user_type = $request->only('user_type');

		$app_id = $request->only('google_app_id');

		switch ($user_type['user_type']) {

			case config('futureed.student'):

				//Student login.

				//get student id by facebook_app_id

				$student_details = $this->student->getStudentByGoogleId($app_id);

				return $this->respondWithData(
					$this->student_service->getStudentDetails($student_details[0]->id)
				);

				break;

			case config('futureed.client'):

				//Client Login

				//get Client id by facebook_app_id

				$client_details = $this->client->getClientByGoogleId($app_id);

				return $this->respondWithData($client_details[0]->toArray());

				break;

			default:

				//TODO: Log issue if not on option.

				return $this->respondErrorMessage(2003);

				break;
		}
	}

}
