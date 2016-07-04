<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ClientValidatorTrait;
use FutureEd\Http\Requests;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Services\ClientServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\PasswordServices;
use FutureEd\Services\SchoolServices;
use FutureEd\Services\UserServices;
use FutureEd\Http\Requests\Api\ClientRegisterRequest;


class ClientRegisterController extends ClientController {
	
	use ClientValidatorTrait;

	protected $password;

	protected $client;

	protected $client_service;

	protected $school_service;

	protected $user_service;

	protected $mail_service;

	public function __construct(
		PasswordServices $passwordServices,
		ClientRepositoryInterface $clientRepositoryInterface,
		ClientServices $clientServices,
		SchoolServices $schoolServices,
		UserServices $userServices,
		MailServices $mailServices
	){
		$this->password = $passwordServices;
		$this->client = $clientRepositoryInterface;
		$this->client_service = $clientServices;
		$this->user_service = $userServices;
		$this->school_service = $schoolServices;
		$this->mail_service = $mailServices;
	}

	public function register(ClientRegisterRequest $request)
	{
		//TODO: for refactoring 
		// cannot be use for teacher registration

		$client = $request->only('first_name', 'last_name', 'client_role', 'street_address'
			, 'city', 'state', 'country', 'zip', 'country_id');

		$user = $request->only('username', 'email', 'first_name', 'last_name', 'password');

		$school = $request->only('school_name', 'school_address', 'school_city', 'school_state'
			, 'school_country', 'school_zip', 'contact_name', 'contact_number', 'school_country_id');

		$input = $request->only('callback_uri');

		$error_msg = trans('errors');

		//TODO: Create password validation.
		$this->addMessageBag($this->checkPassword($user, 'password'));

		if (strtolower($client['client_role']) == strtolower(config('futureed.teacher'))) {

			$this->addMessageBag($this->setErrorCode(2234)
				->setField('client_role')
				->setMessage($error_msg[2234])
				->errorMessage());
		}

		$email_check = $this->client_service->checkClientEmail($user);

		if (!$email_check) {

			$this->addMessageBag($this->setErrorCode(2200)
				->setField('email')
				->setMessage($error_msg[2200])
				->errorMessage());

		}

		$username_check = $this->client_service->checkClientUsername($user);

		if (!$username_check) {

			$this->addMessageBag($this->setErrorCode(2201)
				->setField('username')
				->setMessage($error_msg[2201])
				->errorMessage());

		}


		if (strtolower($client['client_role']) == strtolower(config('futureed.principal'))) {
			$check_school_name = $this->client_service->schoolNameCheck($school);

			if (!$check_school_name) {

				$this->addMessageBag($this->setErrorCode(2202)
					->setField('school_name')
					->setMessage($error_msg[2202])
					->errorMessage());

			}
		}

		$msg_bag = $this->getMessageBag();

		if (!empty($msg_bag)) {
			return $this->respondWithError($msg_bag);
		}

		$user['user_type'] = config('futureed.client');

		// auto activation for client
		$client['account_status'] = config('futureed.accepted');

		// add user, return status
		$user_response = $this->user_service->addUser($user);

		if ($client['client_role'] == config('futureed.principal')) {

		// add school, return status
			$school_response = $this->school_service->addSchool($school);
		}

		if (isset($user_response['status']) || isset($school_response['status'])) {

			$client = array_merge($client, [
				'user_id' => $user_response['id'],
				'school_code' => (isset($school_response['message'])) ? $school_response['message'] : null,
			]);

			$client_response = $this->client_service->addClient($client);

		}

		if (isset($client_response['status'])) {

			$data = $this->user_service->getUser($user_response['id'], 'Client');

			$code = $this->user_service->getConfirmationCode($user_response['id']);

			$data['client_role'] = $client['client_role'];

			// TODO send email with link where code is embedded. fyi no need for client to confirm code.
			$this->mail_service->sendClientRegister($data, $code['confirmation_code'], $input['callback_uri']);

			return $this->respondWithData([
				'id' => $client_response['id'],
			]);
		} else {

			$return = array_merge($user_response, $client_response);

			return $this->respondWithError($return);

		}

	}

}
