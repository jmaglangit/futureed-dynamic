<?php namespace FutureEd\Models\Repository\Client;


use FutureEd\Models\Core\Client;

class ClientRepository implements ClientRepositoryInterface{

    public function getClient($user_id,$role){

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
            'is_account_reviewed'   
        )
            ->where('user_id','=',$user_id)
            ->where('client_role','=',$role)->first();

    }

    public function checkClient($id,$role){
        
         return Client::where('id','=',$id)
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
                    'is_account_reviewed'=> 0,
                    'created_by'        => 1,
                    'updated_by'        => 1,
                ]);
        }catch(Exception $e){
            return $e->getMessage();
        }
        return true;
    }

    public function getClientId($user_id){

          return Client::where('user_id','=',$user_id)->pluck('id');
    }

    public function getRole($user_id){

          return Client::where('user_id','=',$user_id)->pluck('client_role');
    }

    public function verifyClientId($id){

         return Client::select('id','user_id')->where('id','=',$id)->first();

    }

    public function getclientDetails($id){

        return Client::where('id','=',$id)->first();

    }

    public function updateClientDetails($id,$clientData){

        foreach ($clientData as $key => $value) {
            if($value != null){
                
                $update[$key]  = $value;

            }else{

                $update[$key] = null;

            }
        }

        try{

            Client::where('id',$id)->update($update);

        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

	

	/**
	 * Display a listing of clients.
	 *
	 * @param	array	$criteria
	 * @param	int		$limit
	 * @param	int		$offset
	 *
	 * @return array
	 */
	public function getClients($criteria = array(), $limit = 0, $offset = 0) {
		
		$clients = new Client();
		
		$count = 0;
		
		if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {
			
			$count = $clients->count();
		
		} else {
			
			if(count($criteria) > 0) {
				if(isset($criteria['name'])) {
					$clients = $clients->name($criteria['name']);
				}
				
				if(isset($criteria['email'])) {
					$clients = $clients->email($criteria['email']);
				}
				
				if(isset($criteria['client_role'])) {
					$clients = $clients->role($criteria['client_role']);
				}
				
				if(isset($criteria['status'])) {
					$clients = $clients->status($criteria['status']);
				}
				
				if(isset($criteria['school_code'])) {
					$clients = $clients->school_code($criteria['school_code']);
				}
			}
		
			$count = $clients->count();
		
			if($limit > 0 && $offset >= 0) {
				$clients = $clients->offset($offset)->limit($limit);;
			}
														
		}
		
		$clients = $clients->with('user')->orderBy('created_at', 'desc');
		
		return ['total' => $count, 'records' => $clients->get()->toArray()];	
	}
    
}