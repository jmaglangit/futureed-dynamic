<?php namespace FutureEd\Http\Controllers\Api\v1;


use FutureEd\Http\Controllers\Api\v1\ClientController;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClientLoginController extends ClientController {

	public function login(){
        $input = Input::only('username','password','role');

        if(!$this->email($input,'username')){
            
            $this->addMessageBag($this->email($input,'username'));
             
        }else{

             $this->addMessageBag($this->username($input,'username'));
        }
        

        $this->addMessageBag($this->checkPassword($input,'password'));
        $this->addMessageBag($this->clientRole($input,'role'));

        $msg_bag = $this->getMessageBag();

            if(!empty($msg_bag)){
                return $this->respondWithError($msg_bag);
            } 

        
        //check username and password
        $response =$this->user->checkLoginName($input['username'], 'Client');

        if($response['status'] <> 200){

            return $this->respondErrorMessage($response['data']);
        }

        //check if facebook_app_id and google_app_id is empty
        if($this->user->getFacebookId($response['data']) || $this->user->getGoogleId($response['data'])){

            return $this->respondErrorMessage(2001);
        }

        $client_id = $this->client->getClientId($response['data']);

        //check role of user if exist
        $client_role = $this->client->checkClient($client_id,$input['role']);

        if(is_null($client_role)){

            return $this->respondErrorMessage(2001);
        }

        //get client basic detail
        $client_detail = $this->client->getClient($client_role,$input['role']);

        if($client_detail['account_status'] != config('futureed.client_account_status_accepted')){

            return $this->respondErrorMessage(2118);
        }


         //match username and password
        $input['password'] = sha1($input['password']);
        $return  = $this->user->checkPassword($response['data'],$input['password']);

        if(!$return){

            $this->user->addLoginAttempt($response['data']);

            $user = $this->user->getUserDetail($response['data'],'Client');

            if($user['login_attempt'] >=3){

                $this->user->lockAccount($response['data']);

                return $this->respondErrorMessage(2014);

            }


            return $this->respondErrorMessage(2033);
        }

		//get user details
		$user_details = $this->user->getUserDetail($response['data'],config('futureed.client'));

		//check if user is Disabled
		if($user_details['status'] === config('futureed.user_disabled')){

			return $this->respondErrorMessage(2013);
		}

		// Determine return country id  by teacher and principal or parent
		if(strcasecmp($client_detail['client_role'],config('futureed.teacher')) == 0
			|| strcasecmp($client_detail['client_role'],config('futureed.principal')) == 0){

			$country = $client_detail->school['country_id'];
		} else {

			$country =$client_detail['country_id'];
		}

        $this->user->resetLoginAttempt($return['id']);

        return $this->respondWithData([
			'id' => $client_detail['id'],
			'first_name' => $client_detail['first_name'],
			'last_name' => $client_detail['last_name'],
			'country_id' => $country,
        ]);
    }

}
