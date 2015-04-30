<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Models\Repository\School\SchoolRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface;

class ClientServices {

    public function __construct(
        ClientRepositoryInterface $client,
        ValidatorRepositoryInterface $validator,
        UserRepositoryInterface $user,
        SchoolRepositoryInterface $school){
        $this->client = $client;
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

        $check = $this->user->checkEmail($email, $client_role);

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

        $check = $this->user->checkUserName($username, $client_role);

        if(is_null($check)){
            return true;
        }
        else{
            return false;
        }
    }
    public function schoolNameCheck($input){

        $check = $this->school->checkSchoolName($input);

        if(is_null($check)){
            return true;
        }
        else{
            return false;
        }
    }
    public function addClient($client){
        $return = [];

        $addclient_response = $this->client->addClient($client);

        $client_id = $this->client->getClientId($client['user_id']);

        $return = [
            'status'    => 200,
            'id'        => $client_id,
            'message'   => $addclient_response,
        ];

        return $return;
    }

    public function getClientId($user_id){

        return $this->client->getClientId($user_id);
    }

    public function getRole($user_id){

        return $this->client->getRole($user_id);
    }

    public function verifyClientId($id){

        return $this->client->verifyClientId($id);
    }

}