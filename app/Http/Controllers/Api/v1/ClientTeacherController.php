<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\MailServices as Mail;
use FutureEd\Http\Requests\Api\ClientTeacherRequest;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface as Client;
use FutureEd\Models\Repository\User\UserRepositoryInterface as User;
use Illuminate\Support\Facades\Input;

class ClientTeacherController extends ApiController {

	protected $client;
	protected $user;
	protected $code;

	public function __construct(
		Client $client,
		User $user,
		Mail $mail,
		CodeGeneratorServices $codeGeneratorServices
	) {

		$this->client = $client;
		$this->user = $user;
		$this->mail = $mail;
		$this->code = $codeGeneratorServices;

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


		if (Input::get('limit')) {

			$limit = Input::get('limit');

		}


		if (Input::get('offset')) {

			$offset = Input::get('offset');

		}

		if (Input::get('name')) {

			$criteria['name'] = Input::get('name');

		}

		if (Input::get('school_code')) {

			$criteria['school_code'] = Input::get('school_code');

		}

		if (Input::get('email')) {

			$criteria['email'] = Input::get('email');
		}

		$teacher = $this->client->getTeacherDetails($criteria, $limit, $offset);

		return $this->respondWithData($teacher);


	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ClientTeacherRequest $request) {

		$user = $request->only(['email', 'username']);
		$client = $request->only(['first_name', 'last_name', 'current_user']);
		$url = $request->only('callback_uri');

		$client['client_role'] = config('futureed.teacher');
		$user['user_type'] = config('futureed.client');
		$user['first_name'] = $client['first_name'];
		$user['last_name'] = $client['last_name'];
		$user['name'] = $client['first_name'] . " " . $client['last_name'];


		//get current user details
		$current_user_details = $this->client->getClientDetails($client['current_user']);

		//get school_code of current user
		$client['school_code'] = $current_user_details['school_code'];

		//by pass admin approval.
		$client['account_status'] = config('futureed.accepted');

		//add confirmation code
		$user = array_merge($user, $this->code->getCodeExpiry());

		//return newly added user details
		$user = $this->user->addUser($user);

		$client['user_id'] = $user->id;

		//add new client
		$client = $this->client->addClient($client);

		//get user information
		$user = $this->user->getUser($client->user_id, 'all');

		//TODO: merge user details on addClient return data.
		//send email to invited teacher
		$this->mail->sendMailInviteTeacher($user, $client, $current_user_details, $url);

		return $this->respondWithData(['id' => $client->id]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id) {
		$teacher = $this->client->getClientByUserId($id);

		if (!$teacher) {

			return $this->respondErrorMessage(2001);

		}

		return $this->respondWithData($teacher);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function update($id, ClientTeacherRequest $request) {
		$user_type = config('futureed.client');
		$client = $request->only('first_name', 'last_name', 'street_address', 'state', 'city', 'zip', 'country', 'country_id');
		$user['name'] = $client['first_name'] . ' ' . $client['last_name'];

		//add default value for country_id
		if (!$client['country_id']) {

			$client['country_id'] = 0;
		}

		$client_details = $this->client->getClientDetails($id);

		$user['id'] = $client_details['user_id'];

		$this->user->updateUser($user['id'], $user);

		$this->client->updateClientDetails($id, $client);

		$teacher = $this->client->getClientByUserId($id);


		return $this->respondWithData($teacher);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id) {
		//check if this record is related to user before deleting
		$client_details = $this->client->getClientDetails($id);


		if (empty($client_details)) {

			return $this->respondErrorMessage(2001);
		}

		$client_to_classroom = $this->client->getClientToClassroom($id);

		if ($client_to_classroom['classroom']->toArray()) {

			return $this->respondErrorMessage(2119);
		}

		return $this->respondWithData($this->client->deleteClient($id));
	}

	/**
	 * Get Teacher's curriculum country based on what is the curriculum country of the school principal.
	 * @param $client_id
	 * @return mixed
	 */
	public function getCurriculumCountry($client_id){

		//get school - principal - curriculum country if none return 0.
		$teacher = $this->client->getClientDetails($client_id);

		//get curriculum country of the principal ang return
		$country = $teacher->school->principal->user->curriculum_country;

		return $this->respondWithData($country);
	}

}
