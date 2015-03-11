<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use FutureEd\Services\UsersServices;

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
     */
    public function imagePassword(){
        try{
            //get student id
            $input = Input::get('id');
            $status = 200;
            $response = "password candidate $input";

        }catch(Exception $e){
            $status = 400;
            $response = $e->getMessage();
        }
        //return with image file name and image id from student table.
        return [
            'status' => $status,
            'response' => $response
        ];
    }

    /*
     * user id and password
     */
    public function password(){
        //check email and password matched
        try{
            $input = Input::all();
            //get matched return success or not
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





}
