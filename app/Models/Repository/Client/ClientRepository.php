<?php namespace FutureEd\Models\Repository\Client;

use FutureEd\Models\Core\Client;
use FutureEd\Models\Core\Grade;
use FutureEd\Models\Core\User;
use FutureEd\Models\Traits\LoggerTrait;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;


class ClientRepository implements ClientRepositoryInterface
{
	use LoggerTrait;

	/**
	 * @param $user_id
	 * @param $role
	 * @return mixed
	 */
	public function getClient($user_id, $role = 0)
	{
		DB::beginTransaction();

		try{
			$response = Client::with('user','school')
							->userid($user_id)
							->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Gets teacher information for registration.
	 * @param $id
	 * @param $registration_token
	 * @return mixed
	 */
	public function  getTeacher($id, $registration_token){

		DB::beginTransaction();

		try{
			$client = new Client();

			$response = $client->with('user','school')
							->role(config('futureed.teacher'))
							->registrationtoken($registration_token)
							->find($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}


	/**
	 * @param $id
	 * @param $role
	 * @return mixed
	 */
	public function checkClient($id, $role)
	{
		DB::beginTransaction();

		try{
			$response = Client::where('id', '=', $id)
							->where('client_role', '=', $role)->pluck('user_id');

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $client
	 * @return string|static
	 */
	public function addClient($client)
	{
		DB::beginTransaction();

		try {
			$client['country_id'] = isset($client['country_id']) ? $client['country_id'] : 0;

			$response =  Client::create($client);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $user_id
	 * @return mixed
	 */
	public function getClientId($user_id)
	{
		DB::beginTransaction();

		try{
			$response = Client::userId($user_id)->pluck('id');

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $user_id
	 * @return mixed
	 */
	public function getRole($user_id)
	{
		DB::beginTransaction();

		try{
			$response = Client::where('user_id', '=', $user_id)->pluck('client_role');

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function verifyClientId($id)
	{
		DB::beginTransaction();

		try{
			$response = Client::select('id', 'user_id')->where('id', '=', $id)->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getClientDetails($id)
	{
		DB::beginTransaction();

		try{
			$response = Client::with('user')->find($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @param $client
	 * @return bool
	 * @throws Exception
	 */
	public function updateClientDetails($id, $client)
	{
		DB::beginTransaction();

		try {

			$response = Client::where('id', $id)->update($client);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Updates client and it's relationships.
	 * @param $id
	 * @param $data
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|string|static
	 */
	public function updateClient($id,$data){
		DB::beginTransaction();

		try{

			$client = Client::id($id)->role(config('futureed.teacher'))->pluck('user_id');

			//return if no record found.
			if(!$client){

				return false;
			}

			$data['password'] =  (!isset($data['password'])) ?: sha1($data['password']);

			//TODO: to be updated through relationships.

			$user = User::find($client)->update($data);

			$client = Client::find($id)->update($data);

			if($user && $client){

				$response = Client::with('user','school')->find($id);
			} else {
				$response = false;
			}


		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}


	/**
	 * Display a listing of clients.
	 *
	 * @param    array $criteria
	 * @param    int $limit
	 * @param    int $offset
	 *
	 * @return array
	 */
	public function getClients($criteria = array(), $limit = 0, $offset = 0)
	{
		DB::beginTransaction();

		try{
			$clients = new Client();

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $clients->count();

			} else {

				if (count($criteria) > 0) {
					if (isset($criteria['name'])) {
						$clients = $clients->name($criteria['name']);
					}

					if (isset($criteria['email'])) {
						$clients = $clients->email($criteria['email']);
					}

					if (isset($criteria['client_role'])) {
						$clients = $clients->role($criteria['client_role']);
					}

					if (isset($criteria['status'])) {
						$clients = $clients->status($criteria['status']);
					}

					if (isset($criteria['school'])) {
						$clients = $clients->school_name($criteria['school']);
					}

					if (isset($criteria['school_code'])) {
						$clients = $clients->schoolcode($criteria['school_code']);
					}
				}

				$count = $clients->count();

				if ($limit > 0 && $offset >= 0) {
					$clients = $clients->offset($offset)->limit($limit);;
				}

			}

			$clients = $clients->with('user', 'school')->orderBy('created_at', 'desc');

			$response = ['total' => $count, 'records' => $clients->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $criteria
	 * @return mixed
	 */
	public function getClientCustomDetails($criteria)
	{
		DB::beginTransaction();

		try{
			$clients = new Client();

			if (isset($criteria['school_code'])) {
				$clients = $clients->schoolCode($criteria['school_code']);
			}

			//accepts comma separated value. e.g client_role=Parent,Teacher
			if (isset($criteria['client_role'])) {

				$client_role = explode(',',$criteria['client_role'] );

				$clients = $clients->role($client_role);
			}

			if (isset($criteria['name'])) {
				$clients = $clients->name($criteria['name']);
			}

			$clients = $clients->with('user')->activated()->verified()->orderBy('created_at', 'desc');

			$response = $clients->get()->toArray();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getTeacherDetails($criteria = array(), $limit = 0, $offset = 0)
	{
		DB::beginTransaction();

		try{
			$clients = new Client();

			$clients = $clients->teacher()->activated()->verified();

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $clients->count();

			} else {

				if (count($criteria) > 0) {

					if (isset($criteria['name'])) {

						$clients = $clients->name($criteria['name']);

					}

					if (isset($criteria['email'])) {

						$clients = $clients->email($criteria['email']);

					}

					if (isset($criteria['school_code'])) {

						$clients = $clients->schoolcode($criteria['school_code']);

					}
				}

				$count = $clients->count();

				if ($limit > 0 && $offset >= 0) {
					$clients = $clients->offset($offset)->limit($limit);;
				}

			}

			$clients = $clients->with('user')->orderBy('first_name', 'asc');

			$response = ['total' => $count, 'records' => $clients->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @return Client
	 */
	public function getClientByUserId($id)
	{
		DB::beginTransaction();

		try{
			$clients = new Client();
			$clients = $clients->where('id', '=', $id);
			$clients = $clients->with('user')->first();

			$response = $clients;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function getUserId($id)
	{
		try
		{
			return Client::find($id)->user_id;
		}
		catch (\Exception $e)
		{
			$this->errorLog($e->getMessage());

			return false;
		}
	}

	/**
	 * @param $id
	 * @return bool|\Illuminate\Support\Collection|null|string|static
	 */
	public function deleteClient($id)
	{
		DB::beginTransaction();

		try {

			$client = Client::find($id);

			$response = !is_null($client) ? $client->delete() : false;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	//check relation of teacher to classroom

	/**
	 * @param $id
	 * @return Client
	 */
	public function getClassroom($id)
	{
		DB::beginTransaction();

		try{
			$clients = new Client();
			$response = $clients->with('classroom')->where('id', $id)->orderBy('created_at', 'desc')->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @return Client
	 */
	public function getStudent($id)
	{
		DB::beginTransaction();

		try{
			$clients = new Client();
			$response = $clients->with('student')->where('id', $id)->orderBy('created_at', 'desc')->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


	/**
	 * @param $id
	 * @return Client
	 */
	public function getClientToClassroom($id)
	{
		DB::beginTransaction();

		try{
			$clients = new Client();
			$grades = new Grade();

			$grades = $grades->with('classroom')->orderBy('created_at', 'desc');
			$clients = $clients->with('classroom')->orderBy('created_at', 'desc');
			$clients = $clients->where('id', '=', $id)->first();

			$grade = array();

			foreach ($clients['classroom'] as $k => $v) {
				$grade[] = $v['grade_id'];
			}

			$grades = $grades->whereIn('id', $grade)->get();

			if(isset($clients)){

				$clients->grade = $grades;
			}

			$response = $clients;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function getSchoolCode($id){
		DB::beginTransaction();

		try{
			$response = Client::id($id)->pluck('school_code');

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get client role by Id.
	 * @param $id
	 */
	public function getClientRole($id){
		DB::beginTransaction();

		try{
			$response = Client::find($id)->pluck('client_role');

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add new Client Register from Facebook.
	 * @param $data
	 * @return string|static
	 */
	public function addClientFromFacebook($data){

		DB::beginTransaction();

		try{

			//Add user
			$data = array_add($data,'username','NA');

			$data = array_add($data, 'name',$data['first_name'] . ' ' . $data['last_name']);

			//Set client to active.
			$data = array_add($data, 'is_account_activated', 1);

			//Default to USA -- No country code from login response.
			$data['country_id'] = ($data['country_id'] == null ) ?  840 : $data['country_id'];

			$user = User::create($data);

			$data = array_add($data,'user_id',$user->id);

			//Add Client
			Client::create($data);

			$client = $this->getClientByFacebook($data['facebook_app_id']);


		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e);

			return 0;
		}

		DB::commit();

		return $client;
	}

	/**
	 * Get Client by Facebook id.
	 * @param $facebook_id
	 * @return mixed
	 */
	public function getClientByFacebook($facebook_id) {
		DB::beginTransaction();

		try{
			$response = Client::with('user')->facebookId($facebook_id)->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Ad new Client Register from Google.
	 * @param $data
	 * @return int|static
	 */
	public function addClientFromGoogle($data){

		DB::beginTransaction();

		try{

			//Add user
			$data = array_add($data,'username','NA');

			$data = array_add($data, 'name',$data['first_name'] . ' ' . $data['last_name']);

			//Set client to active.
			$data = array_add($data, 'is_account_activated', 1);

			//Default to USA -- No country code from login response.
			$data['country_id'] = ($data['country_id'] == null ) ?  840 : $data['country_id'];

			$user = User::create($data);

			$data = array_add($data,'user_id',$user->id);

			//Add Client
			Client::create($data);

			$client = $this->getClientByGoogleId($data['google_app_id']);


		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e);

			return 0;
		}

		DB::commit();

		return $client;
	}

	public function getClientByGoogleId($google_id){
		DB::beginTransaction();

		try{
			$response = Client::with('user')->googleId($google_id)->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}