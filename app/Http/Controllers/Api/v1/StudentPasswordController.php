<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Services\PasswordImageServices;
use FutureEd\Services\StudentServices;
use FutureEd\Services\UserServices;
use FutureEd\Http\Requests\Api\StudentPasswordRequest;

class StudentPasswordController extends StudentController {

    protected $password_image;
    protected $student;
    protected $student_service;
    protected $user_service;

    public function __construct(
        PasswordImageServices $passwordImageServices,
        StudentRepositoryInterface $studentRepositoryInterface,
        StudentServices $studentServices,
        UserServices $userServices
    ){
        $this->password_image = $passwordImageServices;
        $this->student = $studentRepositoryInterface;
        $this->student_service = $studentServices;
        $this->user_service = $userServices;
    }

    /**
     * get password images.
     * @return mixed
     */
    public function getPasswordImages(){

        //get images
        $response = $this->password_image->getNewPasswordImages();
        return $this->respondWithData($response['data']);
    }

    /**
     * check password if correct while logged in.
     * @param $id
     * @param StudentPasswordRequest $request
     * @return mixed
     */
    public function confirmPassword($id, StudentPasswordRequest $request){

        $input = $request->only('password_image_id');

        //check user if enabled.
            //get user id
        $user = $this->student->getReferences($id);
        $is_disabled = $this->user_service->checkUserDisabled($user['user_id']);

        if($is_disabled){

            return $this->respondErrorMessage(2012);
        }

        //check student id and password_image_id if matched that won't lock account.
        $response = $this->student_service->checkAccess($id,$input['password_image_id'],1);

        if($response['status'] == 200){

            //get student data
            $response['data'] = $this->student_service->getStudentDetails($id);
        }

        if($response['status'] <> 200){

            return $this->respondErrorMessage(2012);

        }elseif($response['status']==200){

            return $this->respondWithData($response['data']);
        }
    }


    /**
     * reset student password.
     * @param StudentPasswordRequest $request
     * @return mixed
     */
    public function passwordReset(StudentPasswordRequest $request){

        $input = $request->only('id', 'reset_code', 'password_image_id');

        if ($this->student->checkIdExist($input['id'])) {

            if ($this->password_image->checkPasswordExist($input['password_image_id'])) {

                $student_reference = $this->student->getReferences($input['id']);

                $userdata = $this->user_service->getUserDetail($student_reference['user_id'], config('futureed.student'));

                if ($input['reset_code'] == $userdata['reset_code'] || $input['reset_code'] == $userdata['confirmation_code']) {

                    $return = $this->student_service->resetPasswordImage($input);

                    $this->user_service->updateInactiveLock($student_reference['user_id']);


                    return $this->respondWithData(['id' => $return['data']]);
                } else {

                    return $this->respondErrorMessage(2100);
                }
            } else {

                return $this->respondErrorMessage(2101);
            }
        } else {

            return $this->respondErrorMessage(2001);
        }
    }

    /**
     * confirmation of reset code.
     * @param StudentPasswordRequest $request
     * @return mixed
     */
    public function confirmResetCode(StudentPasswordRequest $request){

        $input = $request->only('email', 'reset_code');

        $return = $this->user_service->getIdByEmail($input['email'], config('futureed.student'));

        if ($return['status'] == 202) {

            return $this->respondErrorMessage(2001);

        } else {

            $userdata = $this->user_service->getUserDetail($return['data'], config('futureed.student'));

            if ($userdata['reset_code'] == $input['reset_code']) {

                $expired = $this->user_service->checkCodeExpiry($userdata['reset_code_expiry']);

                if ($expired == true) {

                    return $this->respondErrorMessage(2100);
                } else {


                    $studentdata = $this->student_service->resetCodeResponse($return['data']);
                    return $this->respondWithData($studentdata);
                }
            } else {

                return $this->respondErrorMessage(2100);
            }
        }
    }


    /**
     * confirmation of new image password.
     * @param StudentPasswordRequest $request
     * @return mixed
     */
    public function confirmNewImagePassword(StudentPasswordRequest $request){

        $input = $request->only('id', 'password_image_id');

        if ($this->student->checkIdExist($input['id'])) {

            if ($this->password_image->checkPasswordExist($input['password_image_id'])) {

                $student_reference = $this->student->getReferences($input['id']);
                $this->user_service->updateInactiveLock($student_reference['user_id']);
                $return = $this->student_service->resetPasswordImage($input);

                return $this->respondWithData(['id' => $return['data']]);

            } else {

                return $this->respondErrorMessage(2101);
            }
        } else {

            return $this->respondErrorMessage(2001);
        }
    }


    /**
     * change image password.
     * @param $id
     * @param StudentPasswordRequest $request
     * @return mixed
     */
    public function changeImagePassword($id, StudentPasswordRequest $request){

        $input = $request->only('password_image_id');

        if ($this->student->checkIdExist($id)) {
            if ($this->password_image->checkPasswordExist($input['password_image_id'])) {

                $student_reference = $this->student->getReferences($id);

                $this->user_service->updateInactiveLock($student_reference['user_id']);

                $this->student->changePasswordImage($id, $input['password_image_id']);

                return $this->respondWithData(['id' => $id]);

            } else {

                return $this->respondErrorMessage(2101);
            }
        } else {

            return $this->respondErrorMessage(2001);
        }
    }




}
