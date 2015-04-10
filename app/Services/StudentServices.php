<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 5:38 PM
 */

namespace FutureEd\Services;


use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\PasswordImage\PasswordImageRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepository;

class StudentServices {

    public function __construct(
            StudentRepositoryInterface $student,
            PasswordImageServices $password,
            UserServices $user,
            ValidatorRepository $validator){
        $this->student = $student;
        $this->password = $password;
        $this->user = $user;
        $this->validator = $validator;
    }

    public function getStudents(){

        return $this->student->getStudents();
    }

    public function getStudent($id){
        return $this->student->getStudent($id);
    }

    /*
     * @desc Add new student
     *  'first_name',
            'last_name',
            'gender',
            'birthday',
            'school_code',
            'grade_code',
            'country',
            'state',
            'city'
     */
    //TODO: Add more validations on the each data variables.
    public function addStudent($student){

        $return = [];

        //validate datas
        if($this->validator->gender($student['gender'])){
            $return = array_merge($return,[
                'error_code' => 400028,
                'message' => 'Gender not verified'
            ]);
        }

        if(empty(array_filter($return))){
            //if existing add student
            $student_response = $this->student->addStudent($student);

            // if not add user and add student

            return [
                'status' => 200,
                'message' => $student_response
            ];
        }

        return $return;
    }

    public function updateStudent($student){
        $this->student->updateStudent($student);
    }

    public function deleteStudent($id){
        $this->student->deleteStudent($id);
    }

    public function getImagePassword($id){

        //TODO: get image password.
        $imgId= $this->student->getImagePassword($id);

        //mix password id with selections
        $mix = $this->password->getMixImage($imgId);


        shuffle($mix);

        return [
            'status' => 200,
            'data' => $mix
        ];
    }

    public function checkAccess($id,$image_id){
        $is_disabled =  $this->user->checkUserDisabled($id);

        if(!$is_disabled){
            $password_image = $this->student->getImagePassword($id);

            if($image_id == $password_image){
                $this->user->resetLoginAttempt($id);
                return [
                    'status' => 200,
                    'data' => true
                ];
            } else {
                $this->user->addLoginAttempt($id);
                if(!$this->user->exceedLoginAttempts($id)){
                    $this->user->lockAccount($id);
                    return $this->user->checkUserDisabled($id);
                }
                return [
                    'status' => 202,
                    'data' => "does not match"
                ];
            }
        } else {
            return [
                'status' => 202,
                'data' => $is_disabled
            ];
        }
    }


    public function getStudentDetails($id){
        $student = $this->getStudent($id);
        $user = $this->user->getUser($id);
        $age = $this->age($student->birth_date);
        $return = [
            'id' => $student->user_id,
            'first_name' => $student->first_name,
            'last_name' => $student->last_name,
            'gender' => $student->gender,
            'birth_date' => $student->birth_date,
            'username' => $user->username,
            'email' => $user->email,
            'learning_style'=>$student->learning_style_id,
            'age'=>$age,
            'avatar_id' => $student->avatar_id
        ];

        return $return;

    }
    public function age($birth_date){
         $interval = date_diff(date_create(),date_create($birth_date));
         return $interval->format("%Y");
    }





}