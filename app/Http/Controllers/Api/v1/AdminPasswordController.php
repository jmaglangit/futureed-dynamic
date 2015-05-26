<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ClientValidatorTrait;
use FutureEd\Http\Controllers\Api\v1\ClientController;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminPasswordController extends ApiController {

    /**
     * Admin forgot password.
     *
     * @param $id
     * @return mixed
     */
     public function forgotPassword($id){

        $input = input::only('reset_code','password');
        $admin = config('futureed.admin');

        $this->addMessageBag($this->validateVarNumber($id));
        $this->addMessageBag($this->validateNumber($input,'reset_code'));
        $this->addMessageBag($this->checkPassword($input,'password'));

        $password = sha1($input['password']);
        
        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $return = $this->admin->verifyAdminId($id);

            if($return){

                $userDetails = $this->user->getUserDetail($return['user_id'],$admin);

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

       $input = input::only('new_password');
       $user_type = config('futureed.admin');

       $this->addMessageBag($this->validateVarNumber($id));
       $this->addMessageBag($this->checkPassword($input,'new_password'));

       $new_password = sha1($input['new_password']);

       $msg_bag = $this->getMessageBag();

       if($msg_bag){

           return $this->respondWithError($msg_bag);

       }

       $return = $this->admin->verifyAdminId($id);

       if(!$return){

           return $this->respondErrorMessage(2001);
       }

       //update the password of admin user
       $this->user->updatePassword($id,$new_password);

       $user_details = $this->user->getUserDetail($id,$user_type);

       //send email to admin user
       $this->mail->sendAdminChangePassword($user_details,$input['new_password']);

       return $this->respondWithData([
                                       'id' => $return['id']
                                    ]);


   }


	

}