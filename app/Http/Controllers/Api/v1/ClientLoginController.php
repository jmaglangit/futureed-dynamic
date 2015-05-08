<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ClientValidatorTrait;
use FutureEd\Http\Controllers\Api\v1\ClientController;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClientLoginController extends ClientController {

    use ClientValidatorTrait;

	public function login(){
        $input = Input::only('username','password','role');

        $this->addMessageBag($this->validateLoginField($input,'username'));
        $this->addMessageBag($this->validateLoginField($input,'password'));
        $this->addMessageBag($this->clientRole($input,'role'));

        $msg_bag = $this->getMessageBag();

            if(!empty($msg_bag)){
                return $this->respondWithError($msg_bag);
            } 

        $err_msg = config('futureed-error.error_messages');
        //check username and password
        $response =$this->user->checkLoginName($input['username'], 'Client');

        if($response['status'] <> 200){
            return $this->respondErrorMessage(2001);
        }

        //match username and password
        $input['password'] = sha1($input['password']);
        $return  = $this->user->checkPassword($response['data'],$input['password']);

        if(!$return){
            return $this->respondErrorMessage(2233);
        }

        $client_id = $this->client->getClientId($return['id']);

        //check role of user if exist
        $client_role = $this->client->checkClient($client_id,$input['role']);

        if(is_null($client_role)){

            return $this->respondErrorMessage(2001);
        }

        //get client basic detail
        $client_detail = $this->client->getClient($client_role,$input['role']);
        

        //generate token
        $token = $this->token->getToken(
            [
                'url' => Request::capture()->fullUrl(),
            ]
        );

        return $this->respondWithData([
                'id' => $client_detail['id'],
                'first_name' => $client_detail['first_name'],
                'last_name' => $client_detail['last_name']
        ]);
    }

}
