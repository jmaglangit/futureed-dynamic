<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class StudentPasswordController extends StudentController {


    //get password images
    public function getPasswordImages(){

        //get images
        $response = $this->password_image->getNewPasswordImages();
        return $this->setStatusCode($response['status'])->respondWithData($response['data']);
    }
    
    
    public function passwordReset(){
    	
       $input = Input::only('id','reset_code','password_image_id');
       $error = config('futureed-error.error_messages');

       $this->addMessageBag($this->validateNumber($input,'id'));
       $this->addMessageBag($this->validateNumber($input,'reset_code'));
       $this->addMessageBag($this->validateNumber($input,'password_image_id'));
        
       $msg_bag = $this->getMessageBag();
         
       if($msg_bag){
        
          return $this->respondWithError($this->getMessageBag());
         
       } else {
        
          if($this->student->checkIdExist($input['id'])){
            
            if($this->password_image->checkPasswordExist($input['password_image_id'])){
            
               $student_reference = $this->student->getStudentReferences($input['id']);
             
               $userdata=$this->user->getUserDetail($student_reference['user_id'],'Student');

                if($input['reset_code']==$userdata['reset_code'] || $input['reset_code']==$userdata['confirmation_code'] ){
              
                   $return = $this->student->resetPasswordImage($input);
                
                   $this->user->updateInactiveLock($student_reference['user_id']);
                
                
                   return $this->setStatusCode($return['status'])
                            ->respondWithData(['id'=>$return['data']]);
                }else{
                      
                      return $this->respondWithData(['error_code' => 2100,
                                                     'message' => $error[2100] 
                                                   ]);
                }
            }else{
              
                return $this->respondWithData(['error_code' => 2101,
                                                   'message' => $error[2101] 
                                                 ]);
              
            }
            
          }else{
    
                return $this->respondWithData(['error_code' => 2001,
                                                   'message' => $error[2001] 
                                                 ]);
             
          }
        

        }
         
    }
    
    //confirmation of reset code
    public function confirmResetCode(){
       
        $input = Input::only('email','reset_code');
        
         if(!$input['email'] || !$input['reset_code']){
          
           return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                            'message'=>'Parameter validation failed'
                                              ]);
        } else {
          
           $return=$this->user->getIdByEmail($input['email'],'Student');
          
           if($return['status']==202){
              
               return $this->setStatusCode($return['status'])
                          ->respondWithData(['error_code'=>$return['status'],
                                             'message'=>$return['data']
                                           ]);
                        
           }else{

              $userdata = $this->user->getUserDetail($return['data'],'Student');
              
              if($userdata['reset_code']==$input['reset_code']){
                 
                  $expired=$this->user->checkCodeExpiry($userdata['reset_code_expiry']);
                 
                  if($expired==true){

                     return $this->setStatusCode(202)
                              ->respondWithData(['error_code'=>202,'message'=>'Reset code expired']);
                  }else{
                        
                      $this->user->updateInactiveLock($return['data']);
                      $studentdata = $this->student->resetCodeResponse($return['data']);
                      return $this->setStatusCode($return['status'])
                                  ->respondWithData($studentdata);
                  }
              }else{
                 
                  return $this->setStatusCode(202)
                              ->respondWithData(['error_code'=>202,'message'=>'Invalid forgot password reset code']);
              }
                
           }

        }
    }


    public function confirmNewImagePassword(){
    	
      $input = Input::only('id','password_image_id');
    	 if(!$input['id'] && !$input['password_image_id']){
           return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                            'message'=>'Parameter validation failed'
                                              ]);
        } else {
        	$return = $this->student->resetPasswordImage($input); 
              return $this->setStatusCode($return['status'])
                          ->respondWithData(['id'=>$return['data']]);
        }
    }
    
    
    
    public function changeImagePassword($id){
      
      $input = Input::only('password_image_id','access_token');
      
      if(!$input['password_image_id']){
        
          return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                            'message'=>'Empty password_image_id'
                                              ]);
        
      }elseif(!$input['access_token']){
          
          return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                            'message'=>'Empty access_token'
                                              ]);
      }else{
        
         $token = $this->token->decodeToken($input['access_token']);
    
         if($token['status']==true){
            
              $this->student->ChangPasswordImage($id,$input['password_image_id']); 
              return $this->respondWithData(['id'=>$id,
                                              'access_token'=>$input['access_token']
                                            ]);
            
         }else{
            
            return $this->setStatusCode(201)
                        ->respondWithError(['error_code'=>201,
                                            'message'=>'access_token expired'
                                              ]);
          
         }
         
      }
    }




}
