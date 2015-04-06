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
        $input = Input::only('email');

        if(!$input['email']){

            return $this->setStatusCode(422)->respondWithError('Parameter validation failed');

        } else {

            return $this->respond($input);

        }
    }

    public function checkUserName(){

        $input = Input::only('username');
        if(!$input['username']){

            return $this->setStatusCode(422)->respondWithError('Parameter validation failed');

        } else {
//            dd($input);
            return $this->respond($input);

        }

    }


    /*
     * Candidate users registration
     * param firstname, lastname, gender, birthday, email, username, school id,grade
     * response success/fail
     */

    public function add(){
        $input = Input::only(
            'email',
            'username',
            'first_name',
            'last_name',
            'gender',
            'birth_date',
            'school',
            'grade',
            'country',
            'state',
            'city');



        //validate
        //sends email for code






        return $input;
    }

}
