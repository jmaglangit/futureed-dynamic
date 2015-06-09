<?php namespace FutureEd\Models\Repository\Client;

use FutureEd\Models\Core\Client;
use FutureEd\Models\Core\Grade;
use FutureEd\Models\Core\ParentStudent;



class ClientRepository implements ClientRepositoryInterface
{

	//TODO: Need to refactor /improve
    public function getClient($user_id, $role)
    {

        return Client::select(
            'id',
            'user_id',
            'first_name',
            'last_name',
            'client_role',
            'street_address',
            'city',
            'state',
            'country',
            'zip',
            'account_status'
        )
            ->where('user_id', '=', $user_id)
            ->where('client_role', '=', $role)->first();

    }

	/**
	 * Gets teacher information for registration.
	 * @param $id
	 * @param $registration_token
	 * @return mixed
	 */
	public function getTeacher($id, $registration_token){

		$client = new Client();

		return $client->with('user')
			->id($id)
			->role(config('futureed.teacher'))
			->registrationtoken($registration_token)
			->get();

	}



    public function checkClient($id, $role)
    {

        return Client::where('id', '=', $id)
            ->where('client_role', '=', $role)->pluck('user_id');

    }

    public function checkClientEmail($input)
    {
        $email = $input['email'];
        $client_role = $input['client_role'];
    }

    public function addClient($client)
    {

        try {
            Client::insert([
                'user_id' => $client['user_id'],
                'first_name' => $client['first_name'],
                'last_name' => $client['last_name'],
                'client_role' => $client['client_role'],
                'school_code' => $client['school_code'],
                'street_address' => $client['street_address'],
                'city' => $client['city'],
                'state' => $client['state'],
                'country' => $client['country'],
                'zip' => $client['zip'],
                'account_status' => (isset($client['account_status'])) ? $client['account_status'] : config('futureed.client_account_status_pending'),
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    public function getClientId($user_id)
    {

        return Client::where('user_id', '=', $user_id)->pluck('id');
    }

    public function getRole($user_id)
    {

        return Client::where('user_id', '=', $user_id)->pluck('client_role');
    }

    public function verifyClientId($id)
    {

        return Client::select('id', 'user_id')->where('id', '=', $id)->first();

    }

    public function getClientDetails($id)
    {

        return Client::find($id);

    }

    public function updateClientDetails($id, $clientData)
    {

        foreach ($clientData as $key => $value) {
            if ($value != null) {

                $update[$key] = $value;

            } else {

                $update[$key] = null;

            }
        }

        try {

            Client::where('id', $id)->update($update);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
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
            }

            $count = $clients->count();

            if ($limit > 0 && $offset >= 0) {
                $clients = $clients->offset($offset)->limit($limit);;
            }

        }

        $clients = $clients->with('user', 'school')->orderBy('created_at', 'desc');

        return ['total' => $count, 'records' => $clients->get()->toArray()];
    }

    public function getClientCustomDetails($criteria)
    {

        $clients = new Client();

        if (isset($criteria['name'])) {

            $clients = $clients->name($criteria['name']);

        }

        $clients = $clients->with('user')->orderBy('created_at', 'desc');

        return $clients->get()->toArray();


    }

    public function getTeacherDetails($criteria = array(), $limit = 0, $offset = 0)
    {


        $clients = new Client();

        $clients = $clients->teacher();

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
            }

            $count = $clients->count();

            if ($limit > 0 && $offset >= 0) {
                $clients = $clients->offset($offset)->limit($limit);;
            }

        }

        $clients = $clients->with('user')->orderBy('first_name', 'asc');

        return ['total' => $count, 'records' => $clients->get()->toArray()];

    }

    public function getClientByUserId($id)
    {

        $clients = new Client();

        $clients = $clients->where('id', '=', $id);

        $clients = $clients->with('user')->first();

        return $clients;
    }

    public function deleteClient($id)
    {

        try {

            $client = Client::find($id);

            return !is_null($client) ? $client->delete() : false;

        } catch (Exception $e) {

            return $e->getMessage();

        }

        return $client;
    }

    //check relation of teacher to classroom

    public function getClassroom($id)
    {

        $clients = new Client();

        $clients = $clients->with('classroom')->where('id', $id)->orderBy('created_at', 'desc')->first();

        return $clients;
    }

    public function getStudent($id)
    {

        $clients = new Client();

        $clients = $clients->with('student')->where('id', $id)->orderBy('created_at', 'desc')->first();

        return $clients;


    }


    public function getClientToClassroom($id)
    {

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

        return $clients;


    }
}