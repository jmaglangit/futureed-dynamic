<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 5/12/15
 * Time: 4:56 PM
 */

namespace FutureEd\Http\Controllers\Api\Traits;

use FutureEd\Services\TokenServices;
use Illuminate\Support\Facades\Validator;

trait AccessTokenTrait {

//    use ErrorMessageTrait;
//    use MessageBagTrait;

    public function __construct(TokenServices $token_services){

        $this->token_services = $token_services;
    }

    //get token
    public function getToken(){

        return $this->token_services->getToken();
    }

    //validate token
    public function validateToken($token){

        $error_msg = config('futureed-error.error_messages');

        $validator = Validator::make(
            [
                'access_token' => $token
            ],
            [
                'access_token' => 'required|regex:/^[a-zA-Z0-9]*\=\.[a-zA-Z0-9]*\.[a-zA-Z0-9]*$/'
            ]
        );

        if($validator->fails()){

            $validator_msg = $validator->messages()->toArray();

            $return = $this->setErrorCode(2030)
                ->setField('access_token')
                ->setMessage($validator_msg["access_token"][0])
//                ->setMessage($error_msg[2030])
                ->errorMessage();

            $this->addMessageBag($return);

            return 0;
        }

        $token_result = $this->token_services->validateToken($token);

        if(!$token_result){

            $return = $this->setErrorCode(2029)
                ->setField('access_token')
                ->setMessage($error_msg[2029])
                ->errorMessage();

            $this->addMessageBag($return);
        }

    }



}