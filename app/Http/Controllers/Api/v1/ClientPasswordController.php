<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ApiValidatorTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\userervices;
use FutureEd\Services\MailServices;
use FutureEd\Services\CodeGeneratorServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClientPasswordController extends ApiController{

   public function changePassword($id){

        $input = input::only('reset_code','password');
        $client = config('futureed.client');


        $this->addMessageBag($this->validateNumber($input,'reset_code'));
        $this->addMessageBag($this->checkPassword($input,'password'));

        $password = sha1($input['password']);
        
        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $return = $this->client->verifyClientId($id);

            if($return){

                $userDetails = $this->user->getUserDetail($return['user_id'],$client);

                if($input['reset_code'] == $userDetails['reset_code']){

                    $expired = $this->user->checkCodeExpiry($userDetails['reset_code_expiry']);

                    if(!$expired){

                       $this->user->updateInactiveLock($return['user_id']);
                       $this->user->updatePassword($return['user_id'],$password);

                       return $this->respondWithData(['id'=>$id]);

                    }else{

                        return $this->respondErrorMessage(2007);
                    }

                }else{

                    return $this->respondErrorMessage(2100);
                }



            }else{

                return $this->respondErrorMessage(2001);

            }


        }



   }


   
    



}
