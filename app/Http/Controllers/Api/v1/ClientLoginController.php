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

        // if(!$input['username'] || !$input['password'] || !$input['role']){

        //     return $this->setStatusCode(200)->respondWithError([
        //         'error_code' => 204,
        //         'message' => 'Incomplete parameter requirements'
        //     ]);

        // }
        $this->addMessageBag($this->validateLoginField($input,'username'));
        $this->addMessageBag($this->validateLoginField($input,'password'));
        $this->addMessageBag($this->clientRole($input,'role'));

        $msg_bag = $this->getMessageBag();

            if(!empty($msg_bag)){
                return $this->setStatusCode(200)->respondWithError($msg_bag);
            } 

        //check username and password
        $response =$this->user->checkLoginName($input['username'], 'Client');
        if($response['status'] <> 200){
            return $this->setStatusCode($response['status'])
                ->respondWithData(['error_code'=>$response['status'],'message'=>$response['data']]);
        }


        //match username and password
        $input['password'] = sha1($input['password']);
        $return  = $this->user->checkPassword($response['data'],$input['password']);

        if(isset($return['error_code'])){

            return $this->respondWithError($return);
        }

        //check role of user if exist
        $client_role = $this->client->checkClient($return['id'],$input['role']);

        if(is_null($client_role)){

            return $this->respondWithError([
                'error_code' => 204,
                'message' => 'Client does not exist'
            ]);
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
            'status' => 200,
            'data' => [
                'user_id' => $client_detail['user_id'],
                'first_name' => $client_detail['first_name'],
                'last_name' => $client_detail['last_name'],
                'access_token' => $token['access_token']
            ]
        ]);
    }

}
