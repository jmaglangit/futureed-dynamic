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

   public function resetPassword($id){

        $input = Input::only('reset_code','password');
        $client = config('futureed.client');

        $this->addMessageBag($this->validateVarNumber($id));
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

                       return $this->respondWithData(['id'=>$return['id']]);

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


     public function changePassword($id){

        $input = Input::only('password','new_password');
        $client = config('futureed.client');

        $this->addMessageBag($this->validateVarNumber($id));
        $this->addMessageBag($this->checkPassword($input,'password'));
        $this->addMessageBag($this->checkPassword($input,'new_password'));

        $password = sha1($input['password']);
        $new_password = sha1($input['new_password']);

        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $return = $this->client->verifyClientId($id);

            if($return){

                $userDetails = $this->user->getUserDetail($return['user_id'],$client);

                if($password == $userDetails['password']){

                    $this->user->updatePassword($return['user_id'],$new_password);
                    return $this->respondWithData(['id'=>$return['id']]);


                }else{

					return $this->respondWithError([
						'error_code'=> 2114,
						'field' => 'password',
						'message' => config('futureed-error.error_messages.2114')
					]);
                }



            }else{

                return $this->respondErrorMessage(2001);

            }


        }




   }


   public function setPassword($id){

        $input = Input::only('password');
        $client = config('futureed.client');

        $this->addMessageBag($this->validateVarNumber($id));
        $this->addMessageBag($this->checkPassword($input,'password'));

        $password = sha1($input['password']);

        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $return = $this->client->verifyClientId($id);

            if($return){

                $userDetails = $this->user->getUserDetail($return['user_id'],$client);

                    $this->user->updatePassword($return['user_id'],$password);
                    return $this->respondWithData(['id'=>$return['id']]);


            }else{

                return $this->respondErrorMessage(2001);

            }


        }




   }








}
