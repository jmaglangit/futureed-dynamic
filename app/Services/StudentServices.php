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

class StudentServices {

    public function __construct(StudentRepositoryInterface $student, PasswordImageRepositoryInterface $password){
        $this->student = $student;
        $this->password = $password;
    }

    public function getStudents(){

        return $this->student->getStudents();
    }

    public function getStudent($id){
        return $this->student->getStudent($id);
    }

    public function addStudent($student){
        $this->student->addStudent($student);
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
        $image = $this->password->getImage($imgId[0]['password_image_id']);

        return $image;
    }

    public function checkAccess($id,$selected_image){
        $password_image = $this->getImagePassword($id);

        if($selected_image == $password_image[0]['name']){
            return true;
        } else {
            return false;
        }
    }




}