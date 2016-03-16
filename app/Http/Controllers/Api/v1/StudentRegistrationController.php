<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\StudentRegistrationRequest;

class StudentRegistrationController extends StudentController {

    /*
     * Candidate users registration
     */

    public function register(StudentRegistrationRequest $request)
    {
        $student = $request->only(
            'first_name',
            'last_name',
            'gender',
            'birth_date',
            'grade_code',
            'country_id',
            'country',
            'state',
            'city');

        $user = $request->only(
            'username',
            'email',
            'first_name',
            'last_name');

        $input = $request->only('callback_uri');

        //check if username exist
        $check_username = $this->user->checkUsername($user['username'],config('futureed.student'));

        //check if email exist
        $check_email = $this->user->checkEmail($user['email'],config('futureed.student'));


        if($check_username){

            return $this->respondErrorMessage(2201);

        }

        if($check_email){

            return $this->respondErrorMessage(2200);
        }

        $user = array_merge($user,[
            'user_type' => config('futureed.student')
        ]);

        // add user, return status
        $user_response = $this->user->addUser($user);

        if(isset($user_response['status']))
        {
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
            $this->mail->sendStudentRegister($user_response['id'],$input['callback_uri']);

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

    /**
     * Student invited on the class.
     *
     * @param StudentRegistrationRequest $request
     * @return array
     */
    public function invite(StudentRegistrationRequest $request){

        $input = $request->only('id');
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

        return $detail;
    }


}
