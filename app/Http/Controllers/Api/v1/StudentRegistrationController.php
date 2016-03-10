<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\StudentRegistrationRequest;
use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Models\Repository\ClientDiscount\ClientDiscountRepositoryInterface;
use FutureEd\Models\Repository\Country\CountryRepositoryInterface;
use FutureEd\Models\Repository\School\SchoolRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface;
use FutureEd\Services\AvatarServices;
use FutureEd\Services\ClientServices;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\GradeServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\PasswordImageServices;
use FutureEd\Services\PasswordServices;
use FutureEd\Services\SchoolServices;
use FutureEd\Services\StudentServices;
use FutureEd\Services\TokenServices;
use FutureEd\Services\UserServices;

class StudentRegistrationController extends StudentController {

    protected $request;

    public function __construct(UserServices $user, StudentServices $student, SchoolServices $school, PasswordImageServices $password_image,
                                TokenServices $token, MailServices $mailServices, ClientServices $client, GradeServices $grade,
                                AvatarServices $avatar, CodeGeneratorServices $code, AdminRepositoryInterface $admin,
                                PasswordServices $password, ValidatorRepositoryInterface $validatorRepositoryInterface,
                                SchoolRepositoryInterface $schoolRepositoryInterface, CountryRepositoryInterface $countryRepositoryInterface,
                                ClientDiscountRepositoryInterface $clientDiscountRepositoryInterface, StudentRegistrationRequest $request)
    {
        parent::__construct($user, $student, $school, $password_image, $token, $mailServices, $client, $grade, $avatar, $code, $admin, $password, $validatorRepositoryInterface, $schoolRepositoryInterface, $countryRepositoryInterface, $clientDiscountRepositoryInterface);
        $this->request = $request;
    }


    /*
     * Candidate users registration
     */

    public function register()
    {
        $student = $this->request->only(
            'first_name',
            'last_name',
            'gender',
            'birth_date',
            'grade_code',
            'country_id',
            'country',
            'state',
            'city');

        $user = $this->request->only(
            'username',
            'email',
            'first_name',
            'last_name');

        $input = $this->request->only('callback_uri');

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
     * @return array
     */
    public function invite(){

        $input = $this->request->only('id');
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
