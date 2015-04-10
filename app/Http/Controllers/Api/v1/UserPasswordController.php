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
                $this->mail->sendStudentMailResetPassword($return['data'],$code['confirmation_code']);

                return $this->setStatusCode($return['status'])
                            ->respondWithData($return['data']);
            }
            else{
                return $this->setStatusCode($return['status'])
                            ->respondWithData(['error_code'=>$return['status'],'message'=>$return['data']]);
            }
        }

    }
    public function passwordReset(){
         $input = Input::only('user_id','reset_code','password_image_id');
        
        if(!$input['user_id'] && !$input['reset_code'] && !$input['password_image_id']){
           return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                            'message'=>'Parameter validation failed'
                                          ]);
        } else {
           $userdata= $this->user->getUserDetail($input['user_id'],'Student');
           if($input['reset_code']==$userdata['reset_code']){
              $return = $this->user->resetPasswordImage($input); 
              return $this->setStatusCode($return['status'])
                          ->respondWithData(['id'=>$return['data']]);
           }else{
                return $this->setStatusCode(202)
                            ->respondWithData(['error_code'=>202,'message'=>'Invalid forgot password reset code']);
           }
           

        }
         
    }
    //confirmation of reset code
    public function confirmResetCode(){
        $input = Input::only('email','reset_code');
         if(!$input['email'] && !$input['reset_code']){
           return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                            'message'=>'Parameter validation failed'
                                              ]);
        } else {
           $return=$this->user->checkLoginName($input['email'],'Student');
           if($return['status']==200){
                $userdata = $this->user->getUserDetail($return['data'],'Student');
                if($userdata['reset_code']==$input['reset_code']){
                    $expired=$this->user->checkResetCodeExpiry($userdata['reset_code_expiry']);
                    if($expired==true){
                       return $this->setStatusCode(202)
                                ->respondWithData(['error_code'=>202,'message'=>'Reset code expired']);
                    }else{
                        $return['data']=$this->user->resetCodeResponse($userdata);
                        return $this->setStatusCode($return['status'])
                                    ->respondWithData($return['data']);
                    }
                }else{
                    return $this->setStatusCode(202)
                                ->respondWithData(['error_code'=>202,'message'=>'Invalid forgot password reset code']);
                }

           }else{
                 return $this->setStatusCode($return['status'])
                             ->respondWithData(['error_code'=>$return['status'],'message'=>$return['data']]);
           }

        }

    }


}
