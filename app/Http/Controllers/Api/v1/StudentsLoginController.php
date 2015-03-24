<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class StudentsLoginController extends StudentsController{

    //check email or username if valid user
    public function login(){

            $input = Input::only('username');

            if(!$input['username']){

                return $this->respondNotFound();

            }else{

                //check if username exist, return id else nothing
                $response = $this->user->checkLoginName($input['username'], 'Student');

                return $this->setStatusCode($response['status'])->respondWithData($response['data']);

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

            return $this->respondNotFound();

        } else {

            //TODO: Get image password of student.
//                $this->user->checkUserId($input['user_id']);
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
        $input = Input::only('user_id','image_id');

        if(!$input['user_id'] && !$input['image_id']){

            return $this->respondNotFound();

        } else {

            // get username id, and image password matched, return success/fail (boolean).
            // check login attempts
            $isDisabled = $this->user->checkUserDisabled($input['user_id']);
            if($isDisabled){
                $response = $isDisabled;
            } else {
                $response  = $this->student->checkAccess($input['user_id'],$input['image_id']);
            }


            return $this->respond($response);

        }

    }

    /*
     * param id, image password
     * response success/fail
     */
    public function resetPassword(){

        $input = Input::only('id','password');
        if(!$input['id'] && !$input['password']){

            return $this->respondNotFound();

        } else {
//            dd($input);
            return $this->respond($input);

        }
    }

    /*
     * param username/email
     * response success/fail(doesn't exist)
     */
    public function forgotPassword(){
        //TODO: check username is exist, send email under student
        $input = Input::only('username');

        $this->mail->sendMail();

        if(!$input['username']){

            return $this->respondNotFound();

        } else {

            $response = $this->user->checkLoginName($input['username'], 'Student');



            return $this->setStatusCode($response['status'])->respondWithData($response['data']);
        }

    }







}
