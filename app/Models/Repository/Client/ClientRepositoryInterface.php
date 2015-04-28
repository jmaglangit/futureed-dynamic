<?php namespace FutureEd\Models\Repository\Client;

interface ClientRepositoryInterface {


    public function getClient($user_id,$role);

    public function checkClient($id,$role);

    public function getClientId($user_id);


}