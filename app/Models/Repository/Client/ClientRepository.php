<?php namespace FutureEd\Models\Repository\Client;


use FutureEd\Models\Core\Client;

class ClientRepository implements ClientRepositoryInterface{

    public function getClient($user_id,$role){

        return Client::select(
            'user_id',
            'first_name',
            'last_name',
            'client_role',
            'street_address',
            'city',
            'state',
            'country',
            'zip',
            'status'
        )
            ->where('user_id','=',$user_id)
            ->where('client_role','=',$role)->first();

    }

    public function checkClient($user_id,$role){

         return Client::where('user_id','=',$user_id)
                ->where('client_role','=',$role)->pluck('user_id');

    }

    public function getClientId($user_id){

          return Client::where('user_id','=',$user_id)->pluck('id');
    }

}