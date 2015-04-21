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
                       ->respondWithError(array(['error_code' => 422,
                                                  'field' => 'username',   
                                                  'message' => 'missing required field username'
                                                 ],
                                                 ['error_code' => 422,
                                                  'field' => 'user_type',   
                                                  'message' => 'missing required field user_type'
                                                ]));
                       
        }elseif(!$input['username']){
            
            return $this->setStatusCode(422)
                        ->respondWithError(['error_code' => 422,
                                            'field' => 'username',
                                            'message' => 'missing required field username'
                                          ]);
                        
        
        }elseif(!$input['user_type']){
            
            return $this->setStatusCode(422)
                        ->respondWithError(['error_code' => 422,
                                            'field' => 'user_type',
                                            'message' => 'missing required field user_type'
                                          ]);
            
            
        } else {

            $return= $this->user->checkLoginName($input['username'],$input['user_type']);

            if($this->valid->email($input['username'])){
               
                $return = $this->user->checkEmail($input['username'],$input['user_type']);


            }elseif($this->valid->username($input['username'])){
               
                $return = $this->user->checkUserName($input['username'],$input['user_type']);

            }
            

           if(array_key_exists("status",$return)){
            
                $userDetails = $this->user->getUserDetails($return['user_id']);
                
                $isActivated = $this->user->isActivated($return['user_id']);
                
                if($isActivated==1){
                    
                    
                    // get code 
                    $code=$this->code->getCodeExpiry();

                     //update reset_code and expiry to db
                    $this->user->setResetCode($return['user_id'],$code);


                     //sent email for reset password
                    $this->mail->sendStudentMailResetPassword($userDetails,$code['confirmation_code']);

                    return $this->respondWithData($userDetails);
                    
                }else{
                    
                    return $this->setStatusCode(201)
                                ->respondWithData(['error_code' => 201,
                                                    'field' => 'username',
                                                    'message' => 'invalid username/email'
                                                 ]);
                         
                }
                
          }else{
            
             return $this->setStatusCode(201)
                         ->respondWithData(['error_code' => 201,
                                            'field' => 'username',
                                            'message'=>$return['message']
                                          ]);
          }
        }

    }

    public function passwordReset(){
         
    }

    //confirmation of reset code
    public function confirmResetCode(){
      

    }


}
