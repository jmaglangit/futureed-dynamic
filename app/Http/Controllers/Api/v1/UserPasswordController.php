<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\AccessTokenTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserPasswordController extends UserController {

    use AccessTokenTrait;

    public function passwordForgot(){

        //Check token authentication if valid.
        $access_token = \Request::header('access_token');

        $this->validateToken($access_token);

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

        $input = Input::only('username','user_type');
        $this->addMessageBag($this->userType($input,'user_type'));
        $subject = config('futureed.subject_forgot');

        $flag=0;
        
        if(!$this->email($input,'username')){
            
            $flag = 1;
             
        }
        if(!$this->username($input,'username')){
            
            $flag = 0;
        }
        

        if($flag){

            $this->addMessageBag($this->email($input,'username'));
            
        }else{
          
            $this->addMessageBag($this->username($input,'username'));
            
        }
    
       if($this->getMessageBag()){
         
         return $this->respondWithError($this->getMessageBag());
          
       }else {

            $return= $this->user->checkLoginName($input['username'],$input['user_type']);


            if($this->valid->email($input['username'])){
               
                $return = $this->user->checkEmail($input['username'],$input['user_type']);


            }elseif($this->valid->username($input['username'])) {

                $return = $this->user->checkUserName($input['username'], $input['user_type']);

            }

 
           if(isset($return['status'])){
            
            
                $userDetails = $this->user->getUserDetails($return['user_id']);
                
                $isActivated = $this->user->isActivated($return['user_id']);
                
                if($isActivated==1){
                    
                    
                    // get code 
                    $code=$this->code->getCodeExpiry();

                     //update reset_code and expiry to db
                    $this->user->setResetCode($return['user_id'],$code);


                    if(strcasecmp($input['user_type'],config('futureed.student')) == 0){

                      $this->mail->sendStudentMailResetPassword($userDetails,$code['confirmation_code'],$subject);
                      
                    }elseif(strcasecmp($input['user_type'],config('futureed.client')) == 0){

                      $this->mail->sendClientMailResetPassword($userDetails,$code['confirmation_code'],$subject);

                    }else{

                      $this->mail->sendAdminMailResetPassword($userDetails,$code['confirmation_code'],$subject);

                    }

                    return $this->respondWithData($userDetails);
                    
                }else{
                    
                    return $this->respondErrorMessage(2018);
                         
                }
                
          }else{
            
             return $this->respondErrorMessage(2018);
          }
        }

    }

    public function passwordReset(){


         
    }

    //confirmation of reset code
    public function confirmResetCode(){
      
       $input = Input::only('email','reset_code','user_type');
        $error = config('futureed-error.error_messages');

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->resetCode($input,'reset_code'));
        $this->addMessageBag($this->userType($input,'user_type'));


         $msg_bag = $this->getMessageBag();

         if($msg_bag){

            return $this->respondWithError($this->getMessageBag());

         } else {
          
           $return=$this->user->getIdByEmail($input['email'],$input['user_type']);

          
           if($return['status']==202){
              
               return $this->respondErrorMessage(2001);
                        
           }else{

              $userdata = $this->user->getUserDetail($return['data'],$input['user_type']);
              
              if($userdata['reset_code']==$input['reset_code']){
                 
                  $expired=$this->user->checkCodeExpiry($userdata['reset_code_expiry']);
                 
                  if($expired==true){

                     return $this->respondErrorMessage(2100);
                     
                  }else{
                     
                      if(strcasecmp($input['user_type'],config('futureed.student')) == 0){

                        $studentdata = $this->student->resetCodeResponse($return['data']);
                        return $this->respondWithData($studentdata);

                      }elseif(strcasecmp($input['user_type'],config('futureed.client')) == 0){

                        $id = $this->client->getClientId($return['data']);
                        return $this->respondWithData(['id'=>$id]);

                     }else{

                        $id = $this->admin->getAdminId($return['data']);
                        return $this->respondWithData(['id'=>$id]);

                     }
                  }
              }else{
                 
                  return $this->respondErrorMessage(2100);
              }
                
           }

        }
    }


}
