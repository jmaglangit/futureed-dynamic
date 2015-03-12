<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class StudentsLoginController extends StudentsController{

    //check email or username if valid user
    public function login(){
        try{
            $input = Input::get('username');
            $status = 200;
            //check if email exist
            $response = $this->users->checkLoginName($input);

            $return =  [
                'status' => $status,
                'response' => $response
            ];
        }catch (Exception $e){
            $return = [
                'status' => 400,
                'response' => $e->getMessage()
            ];
        }
        //should return id
        return $return;

    }

    /*
     * image passwords
     * param id
     * response id, image password
     */
    public function imagePassword(){
        try{

            $input = Input::get('id');
            $status = 200;
            //TODO: Get image password of student.
            $response = "password candidate $input";

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
     * param id, image password
     * response success/fail
     */
    public function password(){
        //check email and password matched
        try{
            $input = Input::all();
            //TODO: get username id, and image password matched, return success/fail (boolean).

            $status = 200;
            $response = "TODO";
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
