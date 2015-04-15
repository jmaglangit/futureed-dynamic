<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Client\ClientRepositoryInterface;

class ClientServices {

    public function __construct(ClientRepositoryInterface $client){
        $this->client = $client;

    }

    //get client basic detail
    public function getClient($user_id,$role){

        return  $this->client->getClient($user_id,$role);

    }
    //get user id with role
    public function checkClient($user_id,$role){

        return   $this->client->checkClient($user_id,$role);

    }

}