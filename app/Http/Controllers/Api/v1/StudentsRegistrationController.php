<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;

class StudentsRegistrationController extends StudentsController {



    /*
     * Candidate users registration
     * param firstname, lastname, gender, birthday, email, username, school id,grade
     * response success/fail
     */

    public function register(){
        $input = Input::only(
            'username',
            'email',
            'first_name',
            'last_name',
            'gender',
            'birthday',
            'school_code',
            'grade_code',
            'country',
            'state',
            'city');


        //validate
        $no_data = [];

        if(!$input['username'] || !$input['email'] || !$input['first_name'] || !$input['last_name'] || !$input['gender']|| !$input['birthday']
            || !$input['school_code'] || !$input['grade_code'] || !$input['country'] || !$input['state'] || !$input['city']){

            return $this->setStatusCode(200)->respondWithError([
                'error_code' => 204,
                'message' => 'Invalid parameter'
            ]);
        }

        foreach( $input as $k => $r){

            if(is_null($r)){

            }


        }


        if(!is_null($no_data)){

            return $no_data;

        }

        // add user

        // add student





        return 'done';
    }


}
