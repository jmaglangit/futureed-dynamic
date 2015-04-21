<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Core\User;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class StudentLoginController extends StudentController {

    //check email or username if valid user
    public function login(){

		$input = Input::only('username');
		
		
		if(!$input['username']){
		
			return $this->setStatusCode(422)
        				->respondWithError(['error_code' => 422,
                                            'field' => 'username',
        				                    'message' => 'missing required field username'
			]);
		
		} else {
			
			//check if username exist, return id else nothing
			$response = $this->user->checkLoginName($input['username'], config('futureed.student'));

			$student_id = $this->student->getStudentId($response['data']);
			
			if($response['status'] == 200) {
			
            	return $this->setStatusCode($response['status'])
				->respondWithData(['id' => $student_id]);
                
			} else{
			
            	return $this->setStatusCode($response['status'])
				            ->respondWithData(['error_code' => $response['status'],
                                               'field' => 'username',
                                               'message' => 'invalid username/email']);
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

        if(!$input['id']){

            return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                            'message'=>'Parameter validation failed'
                                         ]);

        } else {

            //TODO: Get image password of student.

                $response = $this->student->getImagePassword($input['id']);
                return $this->setStatusCode($response['status'])->respondWithData($response['data']);
        }

    }

    /*
     * param id, image password
     * response success/fail
     */
    public function password(){
        //check email and password matched
        $input = Input::only('id','image_id');

        if(!$input['id'] || !$input['image_id']){


            return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                             'message'=>'Parameter validation failed'
                                         ]);

        } else {

            // get username id, and image password matched, return success/fail (boolean).

            //get user_id of student
            $student = $this->student->getStudentReferences($input['id']);

            if(is_null($student)){

                return $this->respondWithError([
                    'error_code' => 204,
                    'message' => 'Account does not exist.'
                ]);

            }

            $user_id = $this->student->getStudentReferences($input['id']);
            // check login attempts
            $is_disabled = $this->user->checkUserDisabled($student['user_id']);

            if($is_disabled){

                $response = [
                    'status' => 202,
                    'data' => $is_disabled
                ];


            } else {

                $response  = $this->student->checkAccess($input['id'],$input['image_id']);

                if($response['status'] == 200){

                    //get student data
                    $response['data'] = $this->student->getStudentDetails($input['id']);

                    $token = $this->token->getToken(
                        [
                            'url' => Request::capture()->fullUrl(),
                        ]
                    );
                    $response['data'] = array_merge($response['data'],$token);

                }
            }

            if($response['status']==200){
                return $this->setStatusCode($response['status'])->respondWithData($response['data']);
            }
            else{
               return $this->setStatusCode($response['status'])
                           ->respondWithData(['error_code'=>$response['status'],
                                              'message'=>$response['data']]); 
            }

            

        }

    }


}
