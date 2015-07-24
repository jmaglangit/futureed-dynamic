<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ApiValidatorTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Core\User;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class StudentLoginController extends StudentController {
    
    //check email or username if valid user
    public function login(){

		$input = Input::only('username');

        $parent_message = config('futureed-error.error_messages');
        //$this->addMessageBag($this->emptyUsername($input,'username'));
        
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
        
		}else{
             
			//check if username exist, return id else nothing
			$response = $this->user->checkLoginName($input['username'], config('futureed.student'));
            

           
			if($response['status'] == 200) {
                
                $student_id = $this->student->getStudentId($response['data']);
                
                //get student age
                if($this->student->getAge($student_id) < 14){
                    

                    return $this->respondErrorMessage(2008);

                }else{
			
                	return $this->setStatusCode($response['status'])
    				->respondWithData(['id' => $student_id]);
                
                }
                
                
			} else{

                if($response['data'] == 2014 ){

                    return $this->respondErrorMessage(2019);
                }
			
            	return $this->respondErrorMessage(2001);
			}
        }
			
		
		
    }

    /*
     * image passwords
     * @param id
     * @response id, image password
     */
    public function imagePassword(){

        $input = Input::only('id');

        $this->addMessageBag($this->validateNumber($input,'id'));

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

        $response = $this->student->getImagePassword($input['id']);

        if(!$response){

            return $this->respondErrorMessage(2001);
        }

        return $this->respondWithData($response['data']);


    }

    /*
     * param id, image password
     * response success/fail
     */
    public function loginPassword(){

        $error_msg = config('futureed-error.error_messages');
        //check email and password matched
        $input = Input::only('id','image_id');

        $this->addMessageBag($this->validateNumber($input,'id'));
        $this->addMessageBag($this->validateNumber($input,'image_id'));

        $msg_bag = $this->getMessageBag();
        if(!empty($msg_bag)){

            return $this->respondWithError($this->getMessageBag());
        }



        // get username id, and image password matched, return success/fail (boolean).

        //get user_id of student
        $student = $this->student->getStudentReferences($input['id']);

        if(is_null($student)){

            return $this->respondErrorMessage(2003);
        }

        $user_id = $this->student->getStudentReferences($input['id']);
        // check login attempts
        $is_disabled = $this->user->checkUserDisabled($student['user_id']);

        if($is_disabled){

            $response = [
                'status' => $is_disabled,
            ];

        } else {

            $response  = $this->student->checkAccess($input['id'],$input['image_id']);


            if($response['status'] == 200){

                //get student data
                $response['data'] = $this->student->getStudentDetails($input['id']);



            }
        }

        if($response['status'] <> 200){

            return $this->respondErrorMessage($response['status']);

        }elseif($response['status']==200){

            return $this->respondWithData($response['data']);
        }
    }


}
