<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class StudentsPasswordController extends StudentsController {


    //get password images
    public function getPasswordImages(){

        //get images
        $response = $this->password_image->getNewPasswordImages();
        return $this->setStatusCode($response['status'])->respondWithData($response['data']);
    }
    
    
    public function passwordReset(){
    	
         $input = Input::only('id','reset_code','password_image_id');
        if(!$input['id'] || !$input['reset_code'] || !$input['password_image_id']){
           return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                            'message'=>'Parameter validation failed'
                                          ]);
        } else {
           $userdata= $this->user->getUserDetail($input['id'],'Student');
           if($input['reset_code']==$userdata['reset_code']){
              $return = $this->student->resetPasswordImage($input);
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




}
