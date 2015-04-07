<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Core\User;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class StudentsLoginController extends StudentsController{

    //check email or username if valid user
    public function login(){

            $input = Input::only('username');
          

            if(!$input['username']){

                return $this->setStatusCode(422)
                            ->respondWithError(['error_code'=>422,
                                             'message'=>'Parameter validation failed'
                                         ]);

            }else{
//                check if username exist, return id else nothing
                $response = $this->user->checkLoginName($input['username'], 'Student');
                if($response['status']==200){
                 return $this->setStatusCode($response['status'])
                             ->respondWithData(['user_id'=>$response['data']]);
                }
                else{
                 return $this->setStatusCode($response['status'])
                             ->respondWithData(['error_code'=>$response['status'],'message'=>$response['data']]);
                }

               // return $this->setStatusCode($response['status'])->respondWithData($response['data']);

            }
    }

    /*
     * image passwords
     * @param id
     * @response id, image password
     */
    public function imagePassword(){

        $input = Input::only('user_id');

        if(!$input['user_id']){

            return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                            'message'=>'Parameter validation failed'
                                         ]);

        } else {

            //TODO: Get image password of student.

                $response = $this->student->getImagePassword($input['user_id']);

                return $this->setStatusCode($response['status'])->respondWithData($response['data']);
        }

    }

    /*
     * param id, image password
     * response success/fail
     */
    public function password(){
        //check email and password matched
        $input = Input::only('user_id','image_id','app');


        if(!$input['user_id'] && !$input['image_id']){

            
            return $this->setStatusCode(422)
                        ->respondWithError(['error_code'=>422,
                                             'message'=>'Parameter validation failed'
                                         ]);

        } else {

            // get username id, and image password matched, return success/fail (boolean).
            // check login attempts
            $is_disabled = $this->user->checkUserDisabled($input['user_id']);
            if($is_disabled){
                $response = [
                    'status' => 202,
                    'data' => $is_disabled
                ];

            } else {
                $response  = $this->student->checkAccess($input['user_id'],$input['image_id']);
                if($response['data'] == true){

                    //get student data
                    $response['data'] = $this->student->getStudentDetails($input['user_id']);


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
