<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ApiValidatorTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;

class StudentRegistrationController extends StudentController {

    /*
     * Candidate users registration
     */

    public function register(){

        $student = Input::only(
            'first_name',
            'last_name',
            'gender',
            'birth_date',
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

        //Student fields validations
        $this->addMessageBag($this->firstName($student,'first_name'));
        $this->addMessageBag($this->lastName($student,'last_name'));
        $this->addMessageBag($this->gender($student,'gender'));
        $this->addMessageBag($this->birthDate($student,'birth_date'));
        $this->addMessageBag($this->validateNumber($student,'school_code'));
        $this->addMessageBag($this->validateNumber($student,'grade_code'));
        $this->addMessageBag($this->validateString($student,'country'));
        $this->addMessageBag($this->validateString($student,'state'));
        $this->addMessageBag($this->validateString($student,'city'));

        //User fields validations
        $this->addMessageBag($this->email($user,'email'));
        $this->addMessageBag($this->username($user, 'username'));

        $msg_bag = $this->getMessageBag();
        if(!empty($msg_bag)){

            return $this->respondWithError($this->getMessageBag());
        }


        $user = array_merge($user,[
            'user_type' => config('futureed.student')
        ]);

        // add user, return status
        $user_response = $this->user->addUser($user);

        if(isset($user_response['status'])){
            $student = array_merge($student,[
                'user_id' => $user_response['id']
            ]);

            //add student, resturn status
            $student_response = $this->student->addStudent($student);

        } else {

            $return = $user_response;
            return $this->respondErrorMessage($return['error_code']);

        }

        if(isset($student_response['status'])){



            //send email to user.
            $this->mail->sendStudentRegister($user_response['id']);

            $student_id = $this->student->getStudentId($user_response['id']);
            //return success
            return $this->respondWithData([
                'id' => $student_id
            ]);
        } else {

            //TODO: check if this is have been entered.
            $return = array_merge($user_response,$student_response);

            return $this->respondWithError($return);

        }

    }

    /*
     * returns
     * "user_id,
email,
username,
first_name,
last_name,
gender,
birth_date,
school,
grade,
country,
state,
city"
     */
    public function invite(){
        $input = Input::only('id');
        $user_type = config('futureed.student');

        //get student user
        $user = $this->user->getUser($input['id'],$user_type);

        //get student
        $student  = $this->student->getStudent($input['id']);


        $detail = [
            'id' => $user['id'],
            'username' => $user['username'],
            'first_name' => $user['']
        ];
        //TODO: return invite.


        return $detail;
    }


}
