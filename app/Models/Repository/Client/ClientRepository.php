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

    public function checkClientEmail($input){
        $email = $input['email'];
        $client_role = $input['client_role'];
    }

    public function addClient($client){
        
        try{
            Client::insert([
                    'user_id'           => $client['user_id'],
                    'first_name'        => $client['first_name'],
                    'last_name'         => $client['last_name'],
                    'client_role'       => $client['client_role'],
                    'school_code'       => $client['school_code'],
                    'street_address'    => $client['street_address'],
                    'city'              => $client['city'],
                    'state'             => $client['state'],
                    'country'           => $client['country'],
                    'zip'               => $client['zip'],
                    'created_by'        => 1,
                    'updated_by'        => 1,
                ]);
        }catch(Exception $e){
            return $e->getMessage();
        }
        return true;
    }

    public function getClientId($id){
        return Client::where('user_id','=', $id)->pluck('id');
    }
}