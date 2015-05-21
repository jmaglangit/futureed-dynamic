<?php namespace FutureEd\Http\Controllers\Api\v1;


use FutureEd\Http\Controllers\Api\v1\ClientController;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClientLoginController extends ClientController {

	public function login(){
        $input = Input::only('username','password','role');

        $error_msg = config('futureed-error.error_messages');

        $this->addMessageBag($this->username($input,'username'));
        $check_password = $this->password->checkPassword($input['password']);
        $this->addMessageBag($this->clientRole($input,'role'));

        if(!$check_password){

                $this->addMessageBag($this->setErrorCode(2234)
                                ->setField('password')
                                ->setMessage($error_msg[2112])
                                ->errorMessage());

        }

        $msg_bag = $this->getMessageBag();

            if(!empty($msg_bag)){
                return $this->respondWithError($msg_bag);
            } 

        
        //check username and password
        $response =$this->user->checkLoginName($input['username'], 'Client');

        if($response['status'] <> 200){

            return $this->respondErrorMessage($response['data']);
        }

        //match username and password
        $input['password'] = sha1($input['password']);
        $return  = $this->user->checkPassword($response['data'],$input['password']);

        if(!$return){

            $this->user->addLoginAttempt($response['data']);

            $user = $this->user->getUserDetail($response['data'],'Client');

            if($user['login_attempt'] >=3){

                $this->user->lockAccount($response['data']);

            }


            return $this->respondErrorMessage(2019);
        }

        $client_id = $this->client->getClientId($return['id']);

        //check role of user if exist
        $client_role = $this->client->checkClient($client_id,$input['role']);

        if(is_null($client_role)){

            return $this->respondErrorMessage(2001);
        }

        //get client basic detail
        $client_detail = $this->client->getClient($client_role,$input['role']);

        if($client_detail['is_account_reviewed']==0){

            return $this->respondErrorMessage(2113);
        }
        
        return $this->respondWithData([
                'id' => $client_detail['id'],
                'first_name' => $client_detail['first_name'],
                'last_name' => $client_detail['last_name']
        ]);
    }

}
