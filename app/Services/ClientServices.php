<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface;
use FutureEd\Models\Core\User;
use FutureEd\Models\Core\School;

class ClientServices {

    public function __construct(
        ClientRepositoryInterface $clients,
        ValidatorRepositoryInterface $validator,
        User $user, School $school){
        $this->clients = $clients;
        $this->validator = $validator;
        $this->user = $user;
        $this->school = $school;

    }

    //get client basic detail
    public function getClient($user_id,$role){

        return  $this->client->getClient($user_id,$role);

    }
    //get user id with role
    public function checkClient($user_id,$role){

        return   $this->client->checkClient($user_id,$role);

    }
    public function checkClientEmail($input){
        $email = $input['email'];
        $client_role = 'Client';

        $check = User::where('email','=',$email)
            ->where('user_type','=',$client_role)->pluck('id');

        if(is_null($check)){
            return true;
        }
        else{
            return false;
        }
    }
    public function checkClientUsername($input){
        $username = $input['username'];
        $client_role = 'Client';

        $check = User::where('username','=',$username)
            ->where('user_type','=',$client_role)->pluck('id');

        if(is_null($check)){
            return true;
        }
        else{
            return false;
        }
    }
    public function schoolNameCheck($input){
        $school_name = $input['school_name'];
        $school_address = $input['school_address'];
        $school_state = $input['school_state'];

        $check = School::where('name','=',$school_name)
            ->where('street_address','=',$school_address)
            ->where('state','=',$school_state)->pluck('id');

        if(is_null($check)){
            return true;
        }
        else{
            return false;
        }
    }
    public function addClient($client){
        $return = [];

        $addclient_response = $this->clients->addClient($client);

        $client_id = $this->clients->getClientId($client['user_id']);

        $return = [
            'status'    => 200,
            'id'        => $client_id,
            'message'   => $addclient_response,
        ];

        return $return;
    }
}