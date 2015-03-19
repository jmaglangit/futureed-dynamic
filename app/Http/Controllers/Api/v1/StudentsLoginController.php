<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class StudentsLoginController extends StudentsController{

    //check email or username if valid user
    public function login(){

            $input = Input::get('username');

            if(!$input){

                return $this->respondNotFound();

            }else{

                //check if email exist
                $response = $this->user->checkLoginName($input);

                return $this->respondSuccess($response);

            }
    }

    /*
     * image passwords
     * @param id
     * @response id, image password
     */
    public function imagePassword(){

        $input = Input::get('id');

        if(!$input){

            return $this->respondNotFound();

        } else {

            //TODO: Get image password of student.
                $response = $this->student->getImagePassword($input);

                return $this->respondSuccess($response);
        }

    }

    /*
     * param id, image password
     * response success/fail
     */
    public function password(){
        //check email and password matched
        $input = Input::only('id','image_id');

        if(!$input){

            return $this->respondNotFound();

        } else {

            //TODO: get username id, and image password matched, return success/fail (boolean).
            //TODO: check login attempts
            $isDisabled = $this->user->checkUserDisabled($input['id']);
            if($isDisabled){
                $response = $isDisabled;
            } else {
                $response  = $this->student->checkAccess($input['id'],$input['image_id']);
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
        if(!$input){

            return $this->respondNotFound();

        } else {

            return $this->respond($input);

        }
    }

    /*
     * param username/email
     * response success/fail(doesn't exist)
     */
    public function forgotPassword(){
        //TODO: check email, send email under student
        $input = Input::only('username');
        return $input;
    }







}
