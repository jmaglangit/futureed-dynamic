<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;

class StudentsRegistrationController extends StudentsController {

	//
    public function checkEmail(){
        //check email if exist
        try{
            $input = Input::get('email');
            $status = 200;
            $response = $this->users->checkLoginName($input);;

        }catch (Exception $e){
            $status = 400;
            $response = $e->getMessage();
        }
        return [
            'status' => $status,
            'response' => $response
        ];
    }

    public function checkUserName(){
        try{
            //check username exist
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
     * Candidate users registration
     * param firstname, lastname, gender, birthday, email, username, school id,grade
     * response success/fail
     */

    public function add(){
        $input = Input::only(
                'username',
                'email',
                'first_name',
                'last_name',
                'gender',
                'birthday',
                'school_code',
                'grade_code');

        //validate




        return $input;
    }

}
