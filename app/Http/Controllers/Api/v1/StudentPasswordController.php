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
        return $this->respondWithData($response['data']);
    }

    //check password if correct while logged in.
    public function confirmPassword($id){

        $input = Input::only('password_image_id');
        $error_msg = config('futureed-error.error_messages');


        $this->addMessageBag($this->validateNumber($input,'password_image_id'));
        $this->addMessageBag($this->validateVarNumber($id));

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

        //check user if enabled.
            //get user id
        $user = $this->student->getStudentReferences($id);
        $is_disabled = $this->user->checkUserDisabled($user['user_id']);

        if($is_disabled){

            return $this->respondErrorMessage(2012);
        }

        //check student id and password_image_id if matched that won't lock account.
        $response = $this->student->checkAccess($id,$input['password_image_id'],1);

        if($response['status'] == 200){

            //get student data
            $response['data'] = $this->student->getStudentDetails($id);
        }

        if($response['status'] <> 200){

            return $this->respondErrorMessage(2012);

        }elseif($response['status']==200){

            return $this->respondWithData($response['data']);
        }
    }
    
    
    public function passwordReset(){
    	
       $input = Input::only('id','reset_code','password_image_id');
       $error = config('futureed-error.error_messages');

       $this->addMessageBag($this->validateNumber($input,'id'));
       $this->addMessageBag($this->validateNumber($input,'reset_code'));
       $this->addMessageBag($this->validatePicturePassword($input,'password_image_id'));
        
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
                
                
                   return $this->respondWithData(['id'=>$return['data']]);
                }else{
                      
                      return $this->respondErrorMessage(2100);
                }
            }else{
              
                return $this->respondErrorMessage(2101);
              
            }
            
          }else{
    
                return $this->respondErrorMessage(2001);
             
          }
        

        }
         
    }
    
    //confirmation of reset code
    public function confirmResetCode(){
       
        $input = Input::only('email','reset_code');
        $error = config('futureed-error.error_messages');

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->validateNumber($input,'reset_code'));


         $msg_bag = $this->getMessageBag();

         if($msg_bag){

            return $this->respondWithError($this->getMessageBag());

         } else {
          
           $return=$this->user->getIdByEmail($input['email'],'Student');
          
           if($return['status']==202){
              
               return $this->respondErrorMessage(2001);
                        
           }else{

              $userdata = $this->user->getUserDetail($return['data'],'Student');
              
              if($userdata['reset_code']==$input['reset_code']){
                 
                  $expired=$this->user->checkCodeExpiry($userdata['reset_code_expiry']);
                 
                  if($expired==true){

                     return $this->respondErrorMessage(2100);
                  }else{
                        
                      
                      $studentdata = $this->student->resetCodeResponse($return['data']);
                      return $this->respondWithData($studentdata);
                  }
              }else{
                 
                  return $this->respondErrorMessage(2100);
              }
                
           }

        }
    }


    public function confirmNewImagePassword(){
    	
      $input = Input::only('id','password_image_id');
      $error = config('futureed-error.error_messages');

      $this->addMessageBag($this->validateNumber($input,'id'));
      $this->addMessageBag($this->validateNumber($input,'password_image_id'));

      $msg_bag =$this->getMessageBag();


    	 if($msg_bag){

          return $this->respondWithError($this->getMessageBag());
           
        } else {

          if($this->student->checkIdExist($input['id'])){

            if($this->password_image->checkPasswordExist($input['password_image_id'])){

              $student_reference = $this->student->getStudentReferences($input['id']);
              $this->user->updateInactiveLock($student_reference['user_id']);
              $return = $this->student->resetPasswordImage($input); 
              
              return $this->respondWithData(['id'=>$return['data']]);

            }else{

              return $this->respondErrorMessage(2101);
            }

            
          }else{

            return $this->respondErrorMessage(2001);
          }



        	

        }
    }
    
    
    
    public function changeImagePassword($id){

      $input = Input::only('password_image_id');
      $error = config('futureed-error.error_messages');

      $this->addMessageBag($this->validateNumber($input,'password_image_id'));

      $msg_bag = $this->getMessageBag();

      if($msg_bag){

          return $this->respondWithError($this->getMessageBag());

      }else{

          if($this->student->checkIdExist($id)){
              if($this->password_image->checkPasswordExist($input['password_image_id'])){

                        $student_reference = $this->student->getStudentReferences($id);

                        $this->user->updateInactiveLock($student_reference['user_id']);

                        $this->student->ChangPasswordImage($id,$input['password_image_id']); 
                        
                        return $this->respondWithData(['id' => $id ]);

              }else{

                return $this->respondErrorMessage(2101);

              }

          }else{

            return $this->respondErrorMessage(2001);
          }
         
      }
    }




}
