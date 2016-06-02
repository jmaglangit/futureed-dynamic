<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\ClientRequest;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Services\ClientServices;
use FutureEd\Services\SchoolServices;
use FutureEd\Services\UserServices;
use Illuminate\Support\Facades\Input;

class ClientController extends ApiController {

	protected $client_service;

	protected $user_service;

	protected $client;

	protected $school_service;

	public function __construct(
		ClientServices $clientServices,
		UserServices $userServices,
		SchoolServices $schoolServices,
		ClientRepositoryInterface $clientRepositoryInterface
	){
		$this->client_service = $clientServices;
		$this->user_service = $userServices;
		$this->client = $clientRepositoryInterface;
		$this->school_service = $schoolServices;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		$criteria = array();
		$limit = 0;
		$offset = 0;

		if(Input::get('name')) {
			$criteria['name'] = Input::get('name');
		}

		if(Input::get('school')) {
			$criteria['school'] = Input::get('school');
		}

		if(Input::get('school_code')) {
			$criteria['school_code'] = Input::get('school_code');
		}

		if(Input::get('client_role')) {
			$criteria['client_role'] = Input::get('client_role');
		}

		if(Input::get('email')) {
			$criteria['email'] = Input::get('email');
		}

		if(Input::get('status')) {
			$criteria['status'] = Input::get('status');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		$clients = $this->client_service->getClients($criteria, $limit, $offset);

		return $this->respondWithData($clients);
	}

	/**
	 * Show listing of clients
	 * @param $id
	 * @return mixed
	 */
	public function show($id) {

		$client = config('futureed.client');

		$this->addMessageBag($this->validateVarNumber($id));

		$msg_bag = $this->getMessageBag();

		if (!empty($msg_bag)) {

			return $this->respondWithError($this->getMessageBag());

		} else {

			$return = $this->client_service->verifyClientId($id);

			if ($return) {

				//TODO: make use of relationships.
				$userDetails = $this->user_service->getUserDetail($return['user_id'], $client)->toArray();
				$clientDetails = $this->client_service->getClientDetails($id)->toArray();
				$formResponse = $this->client_service->formResponse($userDetails, $clientDetails);

				return $this->respondWithData($formResponse);

			} else {

				return $this->respondErrorMessage(2001);

			}
		}
	}

	/**
	 * Update listing of clients
	 * @param $id
	 * @param ClientRequest $clientRequest
	 * @return mixed
	 */
	public function update($id, ClientRequest $clientRequest)
	{
		$return = $this->client_service->verifyClientId($id);

		if($return){

			$clientDetails = $this->client_service->getClientDetails($id)->toArray();

			$user = $clientRequest->only('username','email');
			$client = $clientRequest->only('first_name','last_name','street_address',
								  'city','country','zip','state','country_id');

			$school = $clientRequest->only('school_name','school_code','school_street_address','school_city',
									  'school_state','school_country','school_country_id','school_zip','school_contact_name','school_contact_number');

			$checkUsername = $this->user_service->checkUsername($user['username'],'Client');
			$user['name'] = $client['first_name'].' '.$client['last_name'];

			//add default value for country_id
			if(!$client['country_id']){

				$client['country_id'] =0;

			}

			if(!($checkUsername)  || $checkUsername['user_id'] == $clientDetails['user_id'] ){

				if($clientDetails['client_role'] === config('futureed.parent') ||
				   $clientDetails['client_role'] === config('futureed.teacher')){

					$this->user_service->updateUsername($return['user_id'],$user);
					$this->client_service->updateClientDetails($return['id'],$client);

				}else{

					$school_code = $this->school_service->checkSchoolNameExist($school);
					$school_name = $this->school_service->getSchoolName($school['school_code']);

					if(empty($school_name)){

						return $this->respondErrorMessage(2105);

					}else if(isset($school_code) && $school['school_code'] != $school_code){

						return $this->respondErrorMessage(2202);

					}else{

					    $this->user_service->updateUsername($return['user_id'],$user);
						$this->client_service->updateClientDetails($return['id'],$client);
						$this->school_service->updateSchoolDetails($school);

					}

				}

				$clientDetails = $this->client_service->getClientDetails($id)->toArray();
				$userDetails = $this->user_service->getUserDetail($return['user_id'],'Client')->toArray();

				$response = $this->client_service->formResponse($userDetails,$clientDetails);

				return $this->respondWithData($response);

			}else{
				return $this->respondErrorMessage(2104);
			}

		} else {
			return $this->respondErrorMessage(2001);

		}
	}


	/**
	 * Store newly created client
	 *
	 * @param ClientRequest $clientRequest
	 * @return mixed
	 */

	public function store(ClientRequest $clientRequest)
	{

		$user_type = config('futureed.client');

		$client = $clientRequest->only('first_name', 'last_name', 'client_role', 'school_code',
			'street_address', 'city', 'state', 'country', 'zip','country_id');

		$user = $clientRequest->only('username', 'email', 'status');

		$school = $clientRequest->only('school_name', 'school_address', 'school_city',
			'school_state', 'school_country','school_country_id', 'school_zip',
			'contact_name', 'contact_number');

		$input = $clientRequest->only('callback_uri');

		$check_username = $this->user_service->checkUsername($user['username'], $user_type);
		$check_email = $this->user_service->checkEmail($user['email'], $user_type);
		$school['school_street_address'] = $school['school_address'];

		//for teacher get school_code via school name if exist
		$check_school = $this->school_service->getSchoolCode($school['school_name']);

		//for principal check if school is unique
		$school_exist = $this->school_service->checkSchoolNameExist($school);

		if ($check_username) {
			
			return $this->respondErrorMessage(2104);

		} else if ($check_email) {

			return $this->respondErrorMessage(2200);

		} else if (strcasecmp($client['client_role'], config('futureed.teacher')) == 0 && !($check_school)) {

			return $this->respondErrorMessage(2105);

		} else if (strcasecmp($client['client_role'], config('futureed.principal')) == 0 && $school_exist) {

			return $this->respondErrorMessage(2202);

		} else {

			$user['first_name'] = $client['first_name'];
			$user['last_name'] = $client['last_name'];
			$user['user_type'] = $user_type;
			$client['account_status'] = config('futureed.client_account_status_accepted');

			//add user to db
			$user_response = $this->user_service->addUser($user, $client);

			$client['user_id'] = $user_response['id'];

			if (strcasecmp($client['client_role'], config('futureed.principal')) == 0) {

				//add school to db
				$school_response = $this->school_service->addSchool($school);

				$client['school_code'] = $school_response;

			}

			$client_response = $this->client_service->addClient($client);
			$data = $this->user_service->getUser($user_response['id'], 'Client');
			$code = $this->user_service->getConfirmationCode($user_response['id']);
			$data['client_role'] = $client['client_role'];

			// send email to user
			$this->mail->sendClientRegister($data, $code['confirmation_code'], $input['callback_uri']);

			return $this->respondWithData(['id' => $client_response['id']]);

		}
	}

	/**
	 * Delete a client of a given resource
	 *
	 * @param $id
	 * @return mixed
	 */
	public function destroy($id)
	{

		$this->addMessageBag($this->validateVarNumber($id));

		$msg_bag = $this->getMessageBag();

		if ($msg_bag) {

			return $this->respondWithError($msg_bag);

		}

		$return = $this->client_service->getClientDetails($id);

		if (!$return) {

			return $this->respondErrorMessage(2001);
		}

		//check principal if assign to school
		if ($return['school_code'] && $return['client_role'] === config('futureed.principal')) {

			return $this->respondErrorMessage(2121);

		}
		//check relation of teacher to classroom
		$teacher_classroom = $this->client_service->getClassroom($id);

		if ($teacher_classroom['classroom']->toArray() && $return['client_role'] === config('futureed.teacher')) {

			return $this->respondErrorMessage(2122);
		}

		//check parent to student
		$parent_student = $this->client_service->getStudent($id);

		if ($parent_student['student']->toArray() && $return['client_role'] === config('futureed.parent')) {

			return $this->respondErrorMessage(2123);

		}

		return $this->respondWithData([$this->client_service->deleteClient($id)]);


	}

	/**
	 * To check client's billing address
	 *
	 * @param $id
	 * @return mixed
	 */
	public function checkBillingAddress($id)
	{
		$client_details = $this->client_service->getClientDetails($id);

		if($client_details->street_address == null
				|| $client_details->city == null
				|| $client_details->state == null
				|| $client_details->country_id == 0
				|| $client_details->zip == null)
		{
			return $this->respondWithData(['status' => 1]);
		}
		return $this->respondWithData(['status' => 0]);
	}

	/**
	 * Update billing address of the student.
	 * @param ClientRequest $request
	 * @param $id
	 * @return
	 */
	public function updateBillingAddress(ClientRequest $request, $id){

		$client_billing_information = $request->only('city','state','country_id');

		$client = $this->client->updateClientDetails($id,$client_billing_information);

		return $this->respondWithData($client);

	}
}
