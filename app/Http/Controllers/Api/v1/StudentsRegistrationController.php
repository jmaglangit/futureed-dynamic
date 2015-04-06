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
        // add user
        // add student





        return 'done';
    }


}
