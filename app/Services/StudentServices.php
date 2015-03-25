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

class StudentServices {

    public function __construct(
            StudentRepositoryInterface $student,
            PasswordImageServices $password,
            UserServices $user){
        $this->student = $student;
        $this->password = $password;
        $this->user = $user;
    }

    public function getStudents(){

        return $this->student->getStudents();
    }

    public function getStudent($id){
        return $this->student->getStudent($id);
    }

    /*
     * @desc Add new student
     */
    public function addStudent($student){

        //check if existing user

        //if existing add student
        // if not add user and add student



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



}