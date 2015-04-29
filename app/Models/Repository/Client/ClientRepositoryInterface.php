<?php namespace FutureEd\Models\Repository\Client;

interface ClientRepositoryInterface {


    public function getClient($user_id,$role);

    public function checkClient($id,$role);

    public function checkClientEmail($input);

    public function addClient($client);

    public function getClientId($id);

    public function getRole($user_id);


}