<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ApiValidatorTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserPasswordController extends UserController {
  
    public function passwordForgot(){
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


            }elseif($this->valid->username($input['username'])){
               
                $return = $this->user->checkUserName($input['username'],$input['user_type']);

            }
            

           if( array_key_exists("status",$return)){
            
                $userDetails = $this->user->getUserDetails($return['user_id']);
                
                $isActivated = $this->user->isActivated($return['user_id']);
                
                if($isActivated==1){
                    
                    
                    // get code 
                    $code=$this->code->getCodeExpiry();

                     //update reset_code and expiry to db
                    $this->user->setResetCode($return['user_id'],$code);


                     //sent email for reset password
                    $this->mail->sendStudentMailResetPassword($userDetails,$code['confirmation_code'],$subject);

                    return $this->respondWithData($userDetails);
                    
                }else{
                    
                    return $this->setStatusCode(201)
                                ->respondWithData(['error_code' => 201,
                                                    'message' => 'invalid username/email'
                                                 ]);
                         
                }
                
          }else{
            
             return $this->setStatusCode(201)
                         ->respondWithData(['error_code' => 201,
                                            'message'=>'user does not exist'
                                          ]);
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
        $this->addMessageBag($this->validateNumber($input,'reset_code'));


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
                        
                      
                      $id = $this->client->getClientId($return['data']);

                      return $this->respondWithData(['id'=>$id]);
                  }
              }else{
                 
                  return $this->respondErrorMessage(2100);
              }
                
           }

        }
    }


}
