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
                $response = $this->users->checkLoginName($input);

                return $this->respondSuccess($response);

            }
    }

    /*
     * image passwords
     * param id
     * response id, image password
     */
    public function imagePassword(){

            $input = Input::get('id');

            if(!$input){

                return $this->respondNotFound();

            } else {

                //TODO: Get image password of student.
                return $this->respondSuccess();
            }

    }

    /*
     * param id, image password
     * response success/fail
     */
    public function password(){
        //check email and password matched
            $input = Input::all();
            //TODO: get username id, and image password matched, return success/fail (boolean).

            return $this->respondNotFound($input);

    }

    /*
     * param id, image password
     * response success/fail
     */
    public function resetPassword(){

        try{
            $input = Input::only('id','password');
            //TODO: get user_id of student.
            $status = 200;
            $response = $input;

        }catch(Exception $e){
            $status = 400;
            $response = $e->getMessage();
        }

        return [
            'status' => $status,
            'response' => $response
        ];
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
