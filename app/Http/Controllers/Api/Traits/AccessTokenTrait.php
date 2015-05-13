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


    //get token
    public function getToken(){

        return $this->token->getToken();
    }

    //validate token
    public function validateToken($token){

        $error_msg = config('futureed-error.error_messages');

        $validator = Validator::make(
            [
                'authorization' => $token
            ],
            [
                'authorization' => 'required'
            ],
            [
                'required' => $error_msg[2030],
                'regex' => $error_msg[2031]
            ]
        );

        if($validator->fails()){

            $validator_msg = $validator->messages()->toArray();

            $return = $this->setErrorCode(2030)
                ->setField('authorization')
                ->setMessage($validator_msg["authorization"][0])
//                ->setMessage($error_msg[2030])
                ->errorMessage();

            $this->addMessageBag($return);

            return 0;
        }

        $token_result = $this->token->validateToken($token);

        if(!$token_result){

            $return = $this->setErrorCode(2029)
                ->setField('authorization')
                ->setMessage($error_msg[2029])
                ->errorMessage();

            $this->addMessageBag($return);
        }

    }



}