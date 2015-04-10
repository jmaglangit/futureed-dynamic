<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserPasswordController extends UserController {

    public function passwordForgot(){
        $input = Input::only('username','user_type');

        if(!$input['username'] && !$input['user_type']){

           return $this->setStatusCode(422)
                            ->respondWithError(['error_code'=>422,
                                             'message'=>'Parameter validation failed'
                                              ]);
        } else {
            $return= $this->user->checkLoginName($input['username'],$input['user_type']);
            $user_id=$return['data'];
            if($return['status']==200){
                $return['data'] = $this->user->getUserDetails($return['data']);
                // get code 
                $code=$this->code->getCodeExpiry();
                 //update reset_code and expiry to db
                $this->user->setResetCode($user_id,$code);
                 //sent email for reset password
                $this->mail->sendStudentMailResetPassword($return['data']['email'],$code['confirmation_code']);

                return $this->setStatusCode($return['status'])
                            ->respondWithData($return['data']);
            }
            else{
                return $this->setStatusCode($return['status'])
                            ->respondWithData(['error_code'=>$return['status'],'message'=>$return['data']]);
            }

            /**
             * TODO: check user if exist.
             * TODO: if exist generate password reset code.
             * TODO: send email with code and reset link.
             */
        }

    }

    public function passwordReset(){
        $input = Input::only('reset_code');


    }

}
