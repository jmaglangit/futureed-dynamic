<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ApiValidatorTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Core\User;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Services\StudentServices;
use FutureEd\Services\TokenServices;
use FutureEd\Services\UserServices;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class StudentLoginController extends StudentController {

    protected $student;
    protected $student_service;
    protected $user;
    protected $user_service;
    protected $token_service;

    public function __construct(
        StudentRepositoryInterface $studentRepositoryInterface,
        StudentServices $studentServices,
        UserRepositoryInterface $userRepositoryInterface,
        UserServices $userServices,
        TokenServices $tokenServices
    ){
        $this->student = $studentRepositoryInterface;
        $this->student_service = $studentServices;
        $this->user = $userRepositoryInterface;
        $this->user_service = $userServices;
        $this->token_service = $tokenServices;
    }

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
			$response = $this->user_service->checkLoginName($input['username'], config('futureed.student'));


           
			if($response['status'] == 200) {

                //check if facebook_app_id and google_app_id is empty
                if($this->user_service->getFacebookId($response['data']) || $this->user_service->getGoogleId($response['data'])){

                    return $this->respondErrorMessage(2001);
                }
                
                $student_id = $this->student->getStudentId($response['data']);

                //get student age
                if($this->student_service->getAge($student_id) <= config('futureed.student_age_guardian')){
                    

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

        $response = $this->student_service->getImagePassword($input['id']);

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
        $student = $this->student->getReferences($input['id']);

        if(is_null($student)){

            return $this->respondErrorMessage(2003);
        }

        $user_id = $this->student->getReferences($input['id']);
        // check login attempts
        $is_disabled = $this->user_service->checkUserDisabled($student['user_id']);

        if($is_disabled){

            $response = [
                'status' => $is_disabled,
            ];

        } else {

            $response  = $this->student_service->checkAccess($input['id'],$input['image_id']);


            if($response['status'] == 200){

                //get student data
                $response['data'] = $this->student_service->getStudentDetails($input['id']);

                $token = $this->token_service->getToken([
                    'id' => $response['data']['id'],
                    'type' => config('futureed.student')
                ]);



            }
        }

        if($response['status'] <> 200){

            return $this->respondErrorMessage($response['status']);

        }elseif($response['status']==200){

            return $this->setHeader($token)->respondWithData($response['data']);
        }
    }


}
