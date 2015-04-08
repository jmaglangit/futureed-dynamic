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
        $student = Input::only(
            'first_name',
            'last_name',
            'gender',
            'birthday',
            'school_code',
            'grade_code',
            'country',
            'state',
            'city');

        $user = Input::only(
            'username',
            'email',
            'first_name',
            'last_name');


        //validate



        if(!$user['username'] || !$user['email'] || !$user['first_name'] || !$user['last_name'] || !$student['gender']|| !$student['birthday']
            || !$student['school_code'] || !$student['grade_code'] || !$student['country'] || !$student['state'] || !$student['city']){

            return $this->setStatusCode(200)->respondWithError([
                'error_code' => 204,
                'message' => 'Incomplete parameter requirements'
            ]);
        }


        $user = array_merge($user,[
            'user_type' => 'Student'
        ]);

        // add user, return status
        $user_response = $this->user->addUser($user);

        if(isset($user_response['status'])){
            $student = array_merge($student,[
                'user_id' => $user_response['id']
            ]);
            $student_response = $this->student->addStudent($student);

        } else {

            $return = $user_response;
            return $this->respondWithError($return);

        }

        if(isset($student_response['status'])){

            return $this->respondWithData([
                'id' => $user_response['id']
            ]);
        } else {
            $return = array_merge($user_response,$student_response);
            return $this->setStatusCode(200)->respondWithError($return);

        }





    }


}
