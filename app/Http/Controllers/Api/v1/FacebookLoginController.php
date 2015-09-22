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
	 * @var StudentRepositoryInterface
	 */
	protected $student;

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
		ClientRepositoryInterface $clientRepositoryInterface
	){

		$this->student = $studentRepositoryInterface;

		$this->client = $clientRepositoryInterface;

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
				$response = $this->student->addStudentFromFacebook($student_data);

				return ($response) ?
					$this->respondWithData($response) : $this->respondErrorMessage(7000) ;

				break;

			case config('futureed.client'):

				//Registration for Client.
				$response = $this->client->addClientFromFacebook($client_data);

				return ($response) ?
					$this->respondWithData($response) : $this->respondErrorMessage(7000) ;

				break;
		}

	}

}
